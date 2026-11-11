<?php
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function query($sql, $values = []) {
    global $conn;
    $stmt = mysqli_prepare($conn, $sql);
    if ($values) mysqli_stmt_bind_param($stmt, str_repeat('s', count($values)), ...$values);
    mysqli_stmt_execute($stmt);
    return $stmt;
}
function rows($sql, $values = []) {
    return mysqli_fetch_all(mysqli_stmt_get_result(query($sql, $values)), MYSQLI_ASSOC);
}
function one($sql, $values = []) {
    $records = rows($sql, $values);
    return $records[0] ?? null;
}
function post($key, $default = '') {
    return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : $default;
}
function raw_password($key) {
    return isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
}
function redirect($path, $status = 302) {
    global $base;
    header('Location: ' . route_url($path), true, $status);
    exit;
}
function csrf_field() {
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}
function require_role($roles) {
    global $user;
    if (!$user) redirect('login.php');
    if (!in_array($user['role'], (array)$roles, true)) {
        http_response_code(403);
        exit('Access denied. This function belongs to another role.');
    }
}
function need($condition, $message) {
    if (!$condition) throw new Exception($message);
}
function number_value($key, $min, $max, $default = '') {
    $value = post($key, $default);
    need(ctype_digit((string)$value) && (int)$value >= $min && (int)$value <= $max, 'Check the value for ' . $key . '.');
    return (int)$value;
}
function date_value($key, $default = '') {
    $date = post($key, $default);
    $parsed = DateTime::createFromFormat('!Y-m-d', $date);
    need($parsed && $parsed->format('Y-m-d') === $date, 'Enter a valid date.');
    return $date;
}
function audit($action, $details) {
    global $user;
    query('INSERT INTO audit_logs (actor_id, actor_name, actor_role, action, details) VALUES (?, ?, ?, ?, ?)',
        [$user['id'] ?? null, $user['full_name'] ?? null, $user['role'] ?? null, $action, $details]);
}
function badge_image_error($path) {
    $invalid = 'Choose a valid, complete JPG or PNG badge image.';
    $size = @getimagesize($path);
    if (!$size || !in_array($size[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) return $invalid;
    if (min($size[0], $size[1]) < 128 || max($size[0], $size[1]) > 2048) {
        return 'Badge width and height must each be between 128 and 2048 pixels.';
    }
    if (!extension_loaded('gd')) {
        return 'Badge image validation requires the PHP GD extension. Enable it in XAMPP and try again.';
    }

    $jpeg = $size[2] === IMAGETYPE_JPEG;
    $end = $jpeg ? "\xff\xd9" : "\x00\x00\x00\x00IEND\xae\x42\x60\x82";
    if (file_get_contents($path, false, null, -strlen($end)) !== $end) return $invalid;

    // GD otherwise tolerates some incomplete JPEG files. Treat any decoding warning as failure.
    $ignore_warnings = $jpeg ? ini_set('gd.jpeg_ignore_warning', '0') : false;
    $warning = false;
    set_error_handler(static function () use (&$warning) {
        $warning = true;
        return true;
    });
    try {
        $image = $jpeg ? imagecreatefromjpeg($path) : imagecreatefrompng($path);
    } finally {
        restore_error_handler();
        if ($ignore_warnings !== false) ini_set('gd.jpeg_ignore_warning', $ignore_warnings);
    }
    return $image && !$warning ? '' : $invalid;
}
function save_upload($field, $pdf_allowed = false, $badge = false) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return '';
    $file = $_FILES[$field];
    need($file['error'] === UPLOAD_ERR_OK && $file['size'] > 0 && $file['size'] <= 5 * 1024 * 1024, 'Choose a file up to 5 MB.');
    $type = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $types = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    if ($pdf_allowed) $types['application/pdf'] = 'pdf';
    need(isset($types[$type]), $pdf_allowed ? 'Choose a JPG, PNG or PDF.' : 'Choose a JPG or PNG image.');
    if ($badge) {
        $problem = badge_image_error($file['tmp_name']);
        need($problem === '', $problem);
    } elseif ($type !== 'application/pdf') {
        $image = getimagesize($file['tmp_name']);
        need($image && $image[0] * $image[1] <= 40000000, 'Choose a valid image smaller than 40 megapixels.');
    }
    $name = bin2hex(random_bytes(16)) . '.' . $types[$type];
    $folder = __DIR__ . '/../storage/uploads';
    if (!is_dir($folder)) mkdir($folder, 0755, true);
    need(move_uploaded_file($file['tmp_name'], $folder . '/' . $name), 'The file could not be saved.');
    $GLOBALS['new_uploads'][] = $folder . '/' . $name;
    return $name;
}
function success($message, $path) {
    $_SESSION['message'] = $message;
    
    redirect($path, 303);
}
function action_success($entity, $operation, $path, $name = '', $details = '') {
    $label = $entity . ($name !== '' ? ' "' . $name . '"' : '');
    $message = $label . ' ' . $operation . ' successfully.';
    if ($details !== '') $message .= ' ' . $details;
    success($message, $path);
}

function evidence_image($submission,$width=900,$height=480) {
    global $base;
    if (empty($submission['photo'])) return '<p class="notice notice--info">No evidence photo is attached.</p>';
    return '<img class="preview-image" src="'.e($base).'/file.php?type=evidence&amp;id='.(int)$submission['id'].'" alt="Submitted evidence" width="'.(int)$width.'" height="'.(int)$height.'">';
}
