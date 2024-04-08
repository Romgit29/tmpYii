<?php
namespace common\components\services;

use common\models\Post;

class PostService 
{
    public function store($user) {
        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $_POST['title'];
        $post->text = $_POST['text'];
        $post->save();

        return true;
    }

    public function get($authData, $params): array {
        $filters = ['and'];
        $result = Post::find();
        if(isset($params['sortType'])) {
            switch($params['sortType']) {
                case 'date':
                    $result->orderBy(['created_at' => SORT_DESC]);
                    break;
                case 'title':
                    $result->orderBy(['title' => SORT_ASC]);
                    break;
            }
        }
        
        if(isset($params['currentUserPosts'])) array_push($filters, ['=', 'user_id', $authData['id']]);
        if(isset($params['dateFrom'])) array_push($filters, ['>=', 'created_at', strtotime($params['dateFrom'])]);
        if(isset($params['dateTo'])) array_push($filters, ['<=', 'created_at', strtotime($params['dateTo'])]);
        $result->where($filters);
        if(isset($params['limit'])) $result->limit($params['limit']);
        if(isset($params['offset'])) $result->offset($params['offset']);

        return $result->all();
    }
}
?>