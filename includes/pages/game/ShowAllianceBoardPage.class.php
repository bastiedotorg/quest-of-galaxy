<?php

require 'AbstractAlliancePage.class.php';

class ShowAllianceBoardPage extends AbstractAlliancePage
{
    function __construct()
    {
        parent::__construct();
    }

    public function show()
    {
        $mode = isset ($_GET['subpage']) ? $_GET['subpage'] : "overview";
        switch ($mode) {
            case 'thread':
                $this->getThread();
                break;
            case 'category':
                $this->getCategory();
                break;
            default:
                $this->getCategories();
                break;
        }
    }

    protected function postThread($threadId) {
        global $USER;
        Board::get()->createPosting($threadId, $_POST['thread_text'], $USER['id'], );
        $this->redirectTo('game.php?page=allianceBoard&subpage=thread&id='.$threadId);
    }

    public function getThread() {
        $thread = Board::get()->getThread($_GET['id']);
        $this->checkPermission($thread['category_id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->postThread($thread['id']);
        }

        $this->assign([
            "thread" => $thread,
            "postings" => Board::get()->getPostings($_GET['id']),
            "category" => Board::get()->getCategory($thread['category_id']),
        ]);
        $this->display('page.board.thread.tpl');
    }

    public function postCategory() {
        global $USER;
        $this->checkPermission($_GET['id']);
        Board::get()->createThread($_GET['id'], $_POST['thread_name'], $_POST['thread_text'], $USER['id']);
    }
    protected function checkPermission($categoryId)
    {
        global $USER,$LNG;
        // check if category belongs to ally

        if (!Board::get()->checkCategory($USER['ally_id'], $categoryId)) {
            ShowErrorPage::printError($LNG['access_denied']);
        }

    }
    public function getCategory()
    {
        $this->checkPermission($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->postCategory();
        }

        $this->assign([
            "threads" => Board::get()->getThreads($_GET['id']),
            "category" => Board::get()->getCategory($_GET['id']),
        ]);
        $this->display("page.board.category.tpl");
    }

    public function getCategories()
    {
        global $USER;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->postCategories();
        }

        $this->assign([
            "categories" => Board::get()->getCategories($USER['ally_id']),
        ]);
        $this->display('page.board.categories.tpl');
    }

    public function postCategories()
    {
        global $USER;
        Board::get()->createCategory($USER['ally_id'], $_POST['category_name'], 0);
    }
}