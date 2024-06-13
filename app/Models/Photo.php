<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Photo extends Model
{
    protected $table = 'photos';
    protected $primaryKey = "id";
    protected $fillable = ['author_id', 'path', 'comment'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parsedComment(int $word_limit = 0): string|null
    {
        $comment = $word_limit ? Str::limit($this->comment, $word_limit) : $this->comment;

        preg_match_all('/@\w+/', $comment, $matches);

        $links = [];

        foreach ($matches[0] as $match) {
            if($user = User::where("login", substr($match, 1))->first())
                $links += [$match => $user->getLink()];
        }

        foreach ($links as $login => $link) {
            $name = substr($login, 1);
            $comment = str_replace($login, "<a href='$link' class='text-blue-500' title='$name'>$login</a>", $comment);
        }

        return $comment;
    }


}
