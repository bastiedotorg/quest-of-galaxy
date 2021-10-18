<?php

class Board
{
    protected static $instance = null;

    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCategories($allyId)
    {
        $allyId = filter_var($allyId, FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT a.*, u.username AS creator FROM %%BOARD_CATEGORIES%% AS a LEFT JOIN %%USERS%% AS u ON a.latest_post_creator = u.id WHERE a.ally_id = :allyId";
        return Database::get()->select($sql, [":allyId" => $allyId]);
    }

    public function getCategory($categoryId)
    {
        $categoryId = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT * FROM %%BOARD_CATEGORIES%% WHERE `id` = :categoryId";
        return Database::get()->selectSingle($sql, [":categoryId" => $categoryId]);
    }

    public function checkCategory($allyId, $categoryId)
    {
        $allyId = filter_var($allyId, FILTER_SANITIZE_NUMBER_INT);
        $categoryId = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT COUNT(id) AS counter FROM %%BOARD_CATEGORIES%% WHERE ally_id = :allyId AND `id`=:categoryId";
        return Database::get()->selectSingle($sql, [":allyId" => $allyId, ":categoryId" => $categoryId], "counter") == 1;
    }

    public function createCategory($allyId, $name, $order)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING,);
        $allyId = filter_var($allyId, FILTER_SANITIZE_NUMBER_INT);
        $order = filter_var($order, FILTER_SANITIZE_NUMBER_INT);
        $sql = "INSERT INTO %%BOARD_CATEGORIES%% (`ally_id`, `name`, `order`) VALUES(:allyId, :name, :order)";
        return Database::get()->insert($sql, [":allyId" => $allyId, ":name" => $name, ":order" => $order]);
    }

    public function updateCategory($id, $name, $order)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING,);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $order = filter_var($order, FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE %%BOARD_CATEGORIES%% SET `name` = :name, `order` = :order) WHERE `id` = :categoryId LIMIT 1";
        return Database::get()->update($sql, [":categoryId" => $id, ":name" => $name, ":order" => $order]);
    }

    public function deleteCategory($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $sql = "DELETE FROM %%BOARD_CATEGORIES%% WHERE `id` = :categoryId LIMIT 1";
        return Database::get()->delete($sql, [":categoryId" => $id]);
    }

    public function getThreads($categoryId)
    {
        $categoryId = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT a.*, u.username AS creator FROM %%BOARD_THREADS%% AS a LEFT JOIN %%USERS%% AS u ON a.creator_id=u.id WHERE category_id = :categoryId";
        return Database::get()->select($sql, [":categoryId" => $categoryId]);
    }

    public function getThread($threadId)
    {
        $threadId = filter_var($threadId, FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT a.*, u.username AS creator FROM %%BOARD_THREADS%% AS a LEFT JOIN %%USERS%% AS u ON a.creator_id=u.id WHERE a.id = :threadId";
        return Database::get()->selectSingle($sql, [":threadId" => $threadId]);
    }

    public function setLatestPost($threadId, $userId, $categoryId)
    {
        $sql = "UPDATE %%BOARD_THREADS%% SET latest_post_creator=:userId, latest_post_time=:postTime WHERE `id` = :threadId LIMIT 1";
        Database::get()->update($sql, [":userId" => $userId, ":postTime" => TIMESTAMP, ":threadId" => $threadId]);
        $sql = "UPDATE %%BOARD_CATEGORIES%% SET latest_post_creator=:userId, latest_post_time=:postTime, latest_post_thread=:threadId WHERE `id` = :categoryId LIMIT 1";
        Database::get()->update($sql, [":userId" => $userId, ":postTime" => TIMESTAMP, ":threadId" => $threadId, ":categoryId" => $categoryId]);

    }

    public function createThread($categoryId, $name, $text, $creatorId)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING,);
        $text = filter_var($text, FILTER_SANITIZE_STRING,);
        $categoryId = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
        $creatorId = filter_var($creatorId, FILTER_SANITIZE_NUMBER_INT);
        $sql = "INSERT INTO %%BOARD_THREADS%% (`category_id`, `subject`, `created_time`, `creator_id`) VALUES(:categoryId, :name, :currentTime, :creatorId)";
        Database::get()->insert($sql, [":categoryId" => $categoryId, ":name" => $name, ":currentTime" => TIMESTAMP, ":creatorId" => $creatorId]);
        $threadid = Database::get()->lastInsertId();
        $sql = "INSERT INTO %%BOARD_POSTINGS%% (`thread_id`, `creator_id`, `content`, `created_time`) VALUES(:threadId, :creatorId, :content, :currentTime)";
        Database::get()->insert($sql, [":threadId" => $threadid, ":content" => $text, ":currentTime" => TIMESTAMP, ":creatorId" => $creatorId]);
        $this->setLatestPost($threadid, $creatorId, $categoryId);
    }

    public function updateThread($id, $name, $order)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING,);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $order = filter_var($order, FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE %%BOARD_THREADS%% SET `name` = :name, `order` = :order) WHERE `id` = :ThreadId LIMIT 1";
        return Database::get()->update($sql, [":ThreadId" => $id, ":name" => $name, ":order" => $order]);
    }

    public function deleteThread($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $sql = "DELETE FROM %%BOARD_THREADS%% WHERE `id` = :ThreadId LIMIT 1";
        return Database::get()->delete($sql, [":ThreadId" => $id]);
    }

    public function getPostings($threadId)
    {
        $threadId = filter_var($threadId, FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT a.*, u.username as creator FROM %%BOARD_POSTINGS%% AS a 
                LEFT JOIN %%USERS%% AS u ON a.creator_id=u.id 
                WHERE thread_id = :threadId ORDER BY `created_time` DESC";
        return Database::get()->select($sql, [":threadId" => $threadId]);
    }

    public function createPosting($threadId, $text, $creatorId)
    {
        $text = filter_var($text, FILTER_SANITIZE_STRING,);
        $threadId = filter_var($threadId, FILTER_SANITIZE_NUMBER_INT);
        $creatorId = filter_var($creatorId, FILTER_SANITIZE_NUMBER_INT);
        $thread = $this->getThread($threadId);

        $sql = "INSERT INTO %%BOARD_POSTINGS%% (`thread_id`, `creator_id`, `content`, `created_time`) VALUES(:threadId, :creatorId, :content, :currentTime)";
        Database::get()->insert($sql, [":threadId" => $threadId, ":content" => $text, ":currentTime" => TIMESTAMP, ":creatorId" => $creatorId]);
        $this->setLatestPost($threadId, $creatorId, $thread['category_id']);

    }
}

/*
 * create table uni1_board_categories
(
	id int auto_increment,
	ally_id int null,
	name varchar(55) null,
	`order` int null,
	constraint uni1_categories_pk
		primary key (id)
);

create table uni1_board_threads
(
	id int auto_increment,
	category_id int null,
	subject varchar(55) null,
	creator_id int null,
	created_time int null,
	constraint uni1_board_threads_pk
		primary key (id)
);
create table uni1_board_postings
(
	id int auto_increment,
	thread_id int null,
	creator_id int null,
	content text null,
	created_time int null,
	constraint uni1_board_postings_pk
		primary key (id)
);



 */