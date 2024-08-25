<?php

require_once(__DIR__ . '/../utilmethods.php');
require_once(__DIR__ . '/../testconsts.php');
require_once(__DIR__ . '/../../../vendor/autoload.php');

use Integrations\PhpSdk\TiiAssignment;
use Integrations\PhpSdk\TiiClass;
use Integrations\PhpSdk\TiiLTI;
use Integrations\PhpSdk\TiiSubmission;
use Integrations\PhpSdk\TurnitinAPI;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-15 at 16:24:56.
 */
class LaunchTest extends PHPUnit_Framework_TestCase {

    protected static $sdk;
    protected static $tiiClass;
    protected static $studentOne;
    protected static $studentTwo;
    protected static $studentNothing;
    protected static $instructorOne;
    protected static $studentOneMembershipId;
    protected static $studentTwoMembershipId;
    protected static $studentNothingMembershipId;
    protected static $instructorOneMembershipId;
    protected static $testingAssignment;

    private static $classtitle = "LaunchTest Class";

    public static function setUpBeforeClass()
    {
        // fwrite(STDOUT,"\n" . __METHOD__ . "\n");
        self::$sdk = new TurnitinAPI(TII_ACCOUNT, TII_APIBASEURL, TII_SECRET, TII_APIPRODUCT);
        self::$sdk->setDebug(false);

        // create a class all memberships will be made to
        $classToCreate = new TiiClass();
        $classToCreate->setTitle(self::$classtitle);
        self::$tiiClass = self::$sdk->createClass($classToCreate)->getClass();

        // add members to the class
        self::$studentOne     = UtilMethods::getUser("studentonephpsdk@vle.org.uk");
        self::$instructorOne  = UtilMethods::getUser("instructoronephpsdk@vle.org.uk");

        $assignment = new TiiAssignment();
        $assignment->setTitle("Testing assignment");
        $assignment->setClassId(self::$tiiClass->getClassId());
        $assignment->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime('-1 days')));
        $assignment->setDueDate(gmdate("Y-m-d\TH:i:s\Z", strtotime('+14 days')));
        $assignment->setFeedbackReleaseDate(gmdate("Y-m-d\TH:i:s\Z", strtotime('+14 days')));
        $assignment->setResubmissionRule(1);
        $response = self::$sdk->createAssignment($assignment);
        $assignment = $response->getAssignment();
        self::$testingAssignment = self::$sdk->readAssignment($assignment)->getAssignment();

        // enroll users to class
        self::$studentOneMembershipId = UtilMethods::findOrCreateMembership(
            self::$sdk,
            self::$tiiClass->getClassId(),
            self::$studentOne->getUserId(),
            "Learner"
        );

        self::$instructorOneMembershipId = UtilMethods::findOrCreateMembership(
            self::$sdk,
            self::$tiiClass->getClassId(),
            self::$instructorOne->getUserId(),
            "Instructor"
        );
    }

    public static function tearDownAfterClass()
    {
        UtilMethods::clearClasses(self::$sdk, self::$classtitle);
    }

    /**
     * Assert that the given HTML validates
     *
     * Modified <http://git.io/BNxJcA>. Read the terms of service for
     * Validator.nu at <http://about.validator.nu/#tos>.
     *
     * @param string $html The HTML to validate
     */
    public function assertValidHtml($html)
    {
        // Fail if errors
        try {
            $document = new DOMDocument();
            $body = $document->createElement('body'); // No $contents here
            $fragment = $document->createDocumentFragment();
            $fragment->appendXML($html);
            $body->appendChild($fragment);
            $document->appendChild($body);
            $document->saveHTML();
        } catch (Exception $e) {
            $this->fail("HTML output did not validate.");
        }
        $this->assertTrue(true);
    }

    public function testOutputSubmissionForm()
    {
        $submission = new TiiSubmission();
        $submission->setAssignmentId(1234);
        $submission->setTitle('Test Submission');
        $submission->setSubmitterUserId(5678);
        $submission->setRole('Learner');

        $output = self::$sdk->outputSubmissionForm($submission, true, false, true);

        $this->assertValidHtml($output);
        $this->assertContains($submission->getTitle(), $output);
        $this->assertContains((string)$submission->getAssignmentId(), $output);
        $this->assertContains((string)$submission->getSubmitterUserId(), $output);
        $this->assertContains($submission->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputSubmissionForm($submission);
    }

    public function testOutputResubmissionForm()
    {
        $submission = new TiiSubmission();
        $submission->setSubmissionId(1234);
        $submission->setTitle('Test Submission');
        $submission->setSubmitterUserId(5678);
        $submission->setRole('Learner');

        $output = self::$sdk->outputResubmissionForm($submission, false, true, true);

        $this->assertValidHtml($output);
        $this->assertContains($submission->getTitle(), $output);
        $this->assertContains((string)$submission->getSubmissionId(), $output);
        $this->assertContains((string)$submission->getSubmitterUserId(), $output);
        $this->assertContains($submission->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputResubmissionForm($submission);
    }

    public function testOutputDvGradeMarkForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputDvGradeMarkForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        $lti->setAsJson(true);
        self::$sdk->outputDvGradeMarkForm($lti);
    }

    public function testOutputDvReportForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputDvReportForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDvReportForm($lti);
    }

    public function testOutputDvDefaultForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputDvDefaultForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDvDefaultForm($lti);
    }

    public function testOutputDvPeerMarkForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputDvPeermarkForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDvPeermarkForm($lti);
    }

    public function testOutputRubricManagerForm()
    {
        $lti = new TiiLTI();
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputRubricManagerForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputRubricManagerForm($lti);
    }

    public function testOutputRubricViewForm()
    {
        $lti = new TiiLTI();
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputRubricViewForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputRubricViewForm($lti);
    }

    public function testOutputQuickmarkManagerForm()
    {
        $lti = new TiiLTI();
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputQuickmarkManagerForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputQuickmarkManagerForm($lti);
    }

    public function testOutputMessagesForm()
    {
        $lti = new TiiLTI();
        $lti->setUserId(5678);
        $lti->setRole('Learner');

        $output = self::$sdk->outputMessagesForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputMessagesForm($lti);
    }

    public function testOutputUserAgreementForm()
    {
        $lti = new TiiLTI();
        $lti->setUserId(5678);

        $output = self::$sdk->outputUserAgreementForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getUserId(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputUserAgreementForm($lti);
    }

    public function testOutputDownloadZipForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadZipForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadZipForm($lti);
    }

    public function testOutputDownloadPDFZipForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadPDFZipForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadPDFZipForm($lti);
    }

    public function testOutputDownloadGradeMarkZipForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadGradeMarkZipForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadGradeMarkZipForm($lti);
    }

    public function testOutputDownloadXLSForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadXLSForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadXLSForm($lti);
    }

    public function testOutputPeerMarkSetupForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputPeerMarkSetupForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputPeerMarkSetupForm($lti);
    }

    public function testOutputPeerMarkReviewForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputPeerMarkReviewForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputPeerMarkReviewForm($lti);
    }

    public function testOutputDownloadOriginalFileForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadOriginalFileForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadOriginalFileForm($lti);
    }

    public function testOutputDownloadDefaultPDFForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadDefaultPDFForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadDefaultPDFForm($lti);
    }

    public function testOutputDownloadGradeMarkPDFForm()
    {
        $lti = new TiiLTI();
        $lti->setSubmissionId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputDownloadGradeMarkPDFForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getSubmissionId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputDownloadGradeMarkPDFForm($lti);
    }

    public function testOutputCreateAssignmentForm()
    {
        $lti = new TiiLTI();
        $lti->setClassId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputCreateAssignmentForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getClassId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputCreateAssignmentForm($lti);
    }

    public function testOutputEditAssignmentForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputEditAssignmentForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputEditAssignmentForm($lti);
    }

    public function testOutputAssignmentInboxForm()
    {
        $lti = new TiiLTI();
        $lti->setAssignmentId(1234);
        $lti->setUserId(5678);
        $lti->setRole('Instructor');

        $output = self::$sdk->outputAssignmentInboxForm($lti, true);

        $this->assertValidHtml($output);
        $this->assertContains((string)$lti->getAssignmentId(), $output);
        $this->assertContains((string)$lti->getUserId(), $output);
        $this->assertContains($lti->getRole(), $output);

        $this->setOutputCallback(function () {
            // Noop
        });
        self::$sdk->outputAssignmentInboxForm($lti);
    }
}
