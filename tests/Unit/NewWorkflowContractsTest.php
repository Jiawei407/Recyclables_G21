<?php
use PHPUnit\Framework\TestCase;

final class NewWorkflowContractsTest extends TestCase
{
    public function testPresentationKeepsGroupedFormConstraintsAndReviewReasonOptions(): void
    {
        require_once dirname(__DIR__,2).'/includes/role-presentation.php';
        $html='<html><head><meta charset="UTF-8"></head><body><main><form method="post" action="submissions.php?view=submissions-review-submission&amp;id=75"><input type="hidden" name="csrf" value="real-token"><fieldset disabled><select name="review-reason" required><option value="">Choose reason</option><option value="Other" selected>Other</option></select><textarea name="review-notes" maxlength="2000">Original note</textarea><button name="decision" value="rejected" type="submit">Reject</button></fieldset><input name="email" type="email" pattern="[^@]+@[^@]+" value="staff@example.com"><input type="file" name="photo" accept="image/jpeg,image/png" required></form></main></body></html>';
        $fields=static function($text){
            $doc=new DOMDocument();$old=libxml_use_internal_errors(true);$doc->loadHTML($text);libxml_clear_errors();libxml_use_internal_errors($old);
            $xp=new DOMXPath($doc);$result=[];
            foreach($xp->query('//main//form | //main//fieldset | //main//input | //main//select | //main//option | //main//textarea | //main//button') as $node){$attrs=[];foreach($node->attributes as $attr)$attrs[$attr->name]=$attr->value;ksort($attrs);$result[]=[$node->tagName,$attrs,in_array($node->tagName,['option','textarea','button'])?$node->textContent:''];}
            return $result;
        };
        self::assertSame($fields($html),$fields(render_role_layout($html,'coordinator/submissions-review-submission.php',['role'=>'coordinator','full_name'=>'Test reviewer'])));
    }

    public function testGroupedRoutesRetainEveryScreenAndSelectedRecord(): void
    {
        $GLOBALS['base']='/Coding';
        self::assertCount(82,screen_routes());
        foreach(screen_routes() as $logical=>$target){
            self::assertFileExists(dirname(__DIR__,2).'/'.explode('?',$target)[0]);
            self::assertSame('/Coding/'.$target.'&id=37',route_url($logical.'?id=37'));
        }
    }

    public function testRejectionStillRequiresAReason(): void
    {
        $this->expectException(InvalidArgumentException::class);
        review_note('rejected','','');
    }

    public function testOtherReasonStillRequiresAnExplanation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        review_note('needs-revision','Other','');
    }

    public function testSelectedReasonsAndApprovalsKeepTheirOriginalMeaning(): void
    {
        foreach(review_reasons() as $reason){
            if($reason==='Other')continue;
            self::assertSame($reason,review_note('rejected',$reason,''));
            self::assertSame($reason.': More detail',review_note('needs-revision',$reason,'More detail'));
        }
        self::assertSame('More detail',review_note('needs-revision','Other','More detail'));
        self::assertSame('',review_note('approved','',''));
    }

    public function testFinalReviewsStayReadOnly(): void
    {
        foreach(['approved','rejected','needs-revision'] as $status){
            foreach(['approved','rejected','needs-revision'] as $decision)self::assertFalse(can_review($status,$decision));
        }
    }
}
