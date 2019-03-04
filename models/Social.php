<?php

class SocialModel extends Model
{
    public function index()
    {
        $this->query('SELECT social_media.id, social_media.text, social_media.post_date, users.name, users.lastname  FROM social_media inner join users on social_media.users_id = users.id order by social_media.id desc');
        $rows = $this->resultSet();

        return $rows;
    }
}