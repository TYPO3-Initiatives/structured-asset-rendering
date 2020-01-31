<?php
namespace T3sci\StructuredAssetRendering\Tests\Unit\Controller;

/**
 * Test case.
 */
class MainRendererControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \T3sci\StructuredAssetRendering\Controller\MainRendererController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\T3sci\StructuredAssetRendering\Controller\MainRendererController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllMainRenderersFromRepositoryAndAssignsThemToView()
    {

        $allMainRenderers = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mainRendererRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $mainRendererRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMainRenderers));
        $this->inject($this->subject, 'mainRendererRepository', $mainRendererRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('mainRenderers', $allMainRenderers);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
