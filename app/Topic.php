<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class Topic extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
        'topic_content' => '',
    );
    protected $fillable = ['title','description','topic_content'];
    protected $appends = ['enable'];

    function getEnableAttribute() {
        $enable = 0;

        $previousTopicID = Topic::where('id', '<', $this->id)->max('id');

        if (is_null($previousTopicID)) {
            $enable = 1;
        } else {
            Log::info('111 $this->id: '.$this->id.' $previousTopicID: '.$previousTopicID);

            /*
            $easyKUofPreviousTopic = KnowledgeUnit::where('topic_id', '=', $previousTopicID)
                ->where('difficulty_level', '=', '1')
                ->pluck('id');

            $is_done_query = DB::table('users_knowledgeunits')
                ->where('user_id', '=', Auth::user()->id)
                ->where('knowledgeunit_id', '=', $easyKUofPreviousTopic)
                ->first();
*/
            $is_done_query = 1;
            if (!is_null($is_done_query)) {
                $enable = 1;
            }
        }
        return $enable;
    }

    // Knowledge Units will be here
    public function knowledgeunits()
    {
        return $this->hasMany(KnowledgeUnit::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
