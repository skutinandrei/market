<?php
namespace Page;

class Main
{
    public static $searchField = ['id' => 'header-search'];
    public static $searchButton = ['css' => '.search2__button > button'];
    public static $topMenu = ['css' => '.topmenu__list'];

    /**
     * @var AcceptanceTester
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * @param string $searchText text for search
     */
    public function search($searchText)
    {
        $I = $this->tester;

        $I->amOnPage('/');
        $I->waitForElement(self::$searchField, 10);
        $I->fillField(self::$searchField, $searchText);
        $I->click(self::$searchButton);
        $I->waitForElementVisible(self::$topMenu, 10);
    }
}
