create table %PREFIX%board_categories
(
    id                  int auto_increment
    primary key,
    ally_id             int         null,
    name                varchar(55) null,
    `order`             int         null,
    latest_post_time    int         null,
    latest_post_creator int         null,
    latest_post_thread  int         null
    );

create table %PREFIX%board_postings
(
    id           int auto_increment
    primary key,
    thread_id    int  null,
    creator_id   int  null,
    content      text null,
    created_time int  null
);

create table %PREFIX%board_threads
(
    id                  int auto_increment
    primary key,
    category_id         int         null,
    subject             varchar(55) null,
    creator_id          int         null,
    created_time        int         null,
    latest_post_creator int         null,
    latest_post_time    int         null
    );

