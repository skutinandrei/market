<?php

class searchCest
{
    public function _before(\AcceptanceTester $I)
    {
    }

    public function _after(\AcceptanceTester $I)
    {
    }

    public function searchNokia(\AcceptanceTester $I,  Page\Search $searchPage, Page\Main $mainPage)
    {
        //search for 'nokia'
        $mainPage->search('nokia');
        //go to mobile phones category
        $searchPage->openMobileCategory();
        //count how many pages ins search result
        $pagesCount = $searchPage->pagesCount();
        //find item in search results on the each page
        $pageNumber = $searchPage->searchItem($pagesCount, 'Nokia Asha 205 Dual Sim');
        if ($pageNumber == 0) {
            $I->comment('item was not found');    
        }
        else {
            $I->comment('item found on ' . $pageNumber . ' page');    
        }
    }
}
