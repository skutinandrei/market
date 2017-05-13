<?php
namespace Page;

class Search
{
    public static $mobilePhones = [
        'xpath' => '//div[@class="n-brands-note-item__text" and contains(., "Мобильные телефоны")]'
    ];
    public static $header = ['css' => '.headline__header > h1'];
    public static $itemTitle = ['css' => '.snippet-card__header-text'];
    public static $pager = ['css' => 'div.n-pager'];
    public static $nextPage = ['xpath' => '//a[contains(.,"Вперед")]'];
    public static $filterPanel = ['css' => '.n-filter-panel-aside__content'];

    /**
     * @var AcceptanceTester
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * open mobile category on search result page
     */
    public function openMobileCategory()
    {
        $I = $this->tester;

        $I->waitForElementVisible(self::$mobilePhones, 10);
        $I->click(self::$mobilePhones);
        $I->waitForElement(self::$filterPanel, 10);        
    }

    /**
     * get all titles of items represnted on search result page
     * @return array
     */
    public function getTitles()
    {
        $I = $this->tester;

        $titles = $I->grabMultiple(self::$itemTitle);
        return $titles;        
    }

    /**
     * get count of found items on all pages
     * @return integer
     */
    public function pagesCount()
    {
        $I = $this->tester;
        $dataBem = $I->grabAttributeFrom(self::$pager, 'data-bem');
        $dataBemJson = json_decode($dataBem, TRUE);
        $count = $dataBemJson['n-pager']['pagesCount'];
        return $count;
    }

    /**
     * search item on all pages of search result
     * @param $pagesCount integer count of pages to search in
     * @param $itemName string item name which need to find
     * @return page number where item was found
     */
    public function searchItem($pagesCount, $itemName)
    {
        $I = $this->tester;

        $i = 1;
        $pageNumber = 0;
        
        while (($i <= $pagesCount) and ($pageNumber == 0)) {
            //switch to the next page if item was not found
            if ($i > 1) {
                $I->click(self::$nextPage);
                $I->waitForElement('//a[contains(@class, "button_action_yes")]/span[text()="' .$i . '"]', 10);    
            }
            //get item title names on the page
            $titles = $this->getTitles();
            //check if item name is presented on the page
            foreach ($titles as $value) {
                if ($value == $itemName) {
                    $pageNumber = $i;
                    break;
                }
            }
            $i += 1;
        }

        return $pageNumber;       
    }
}
