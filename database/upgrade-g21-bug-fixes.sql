-- Run while connected to the existing Recyclables database.
ALTER TABLE users ADD COLUMN IF NOT EXISTS disabled_permissions VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE achievements
    ADD COLUMN IF NOT EXISTS family_key VARCHAR(80) NOT NULL DEFAULT '',
    ADD COLUMN IF NOT EXISTS tier ENUM('bronze','silver','gold') NOT NULL DEFAULT 'bronze';

ALTER TABLE point_transactions
    ADD COLUMN IF NOT EXISTS reverses_id INT NULL,
    ADD UNIQUE INDEX IF NOT EXISTS uq_point_reversal (reverses_id),
    ADD CONSTRAINT fk_point_reversal FOREIGN KEY IF NOT EXISTS fk_point_reversal (reverses_id)
        REFERENCES point_transactions(id);

ALTER TABLE achievement_rules
    ADD COLUMN IF NOT EXISTS challenge_id INT NULL,
    ADD CONSTRAINT fk_rule_challenge FOREIGN KEY IF NOT EXISTS fk_rule_challenge (challenge_id)
        REFERENCES challenges(id);

ALTER TABLE audit_logs
    ADD COLUMN IF NOT EXISTS actor_name VARCHAR(100) NULL,
    ADD COLUMN IF NOT EXISTS actor_role VARCHAR(20) NULL;

-- The original can-collection challenge already records evidence quantities.
UPDATE challenges
SET tracked_item = 'Aluminum cans'
WHERE tracked_item = 'Approved activity'
  AND title = 'Recycle Aluminium Cans'
  AND description = 'Collect clean aluminium cans and recycle them.'
  AND completion_requirement = 'Upload a photo showing the cans collected.';
