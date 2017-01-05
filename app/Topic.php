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

        Log::info('$previousTopicID: '.$previousTopicID);

        if (is_null($previousTopicID)) {
            $enable = 1;
        } else {
            Log::info('111 $this->id: '.$this->id.' $previousTopicID: '.$previousTopicID);

            $lastEasyAssignment = DB::table('assignments')
                ->select(DB::raw('assignments.id'))
                ->where('difficulty_level', '=', 1)
                ->whereIn('assignments.knowledge_unit_id', function($query) use ($previousTopicID)
                {
                    $query->select(DB::raw('knowledge_units.id'))
                        ->from('knowledge_units')
                        ->where('topic_id', '=', $previousTopicID);
                })
                ->max('id');

            Log::info('$lastEasyAssignment: '.$lastEasyAssignment);

            $is_done_query = DB::table('users_assignments')
                ->where('user_id', '=', Auth::user()->id)
                ->where('assignment_id', '=', $lastEasyAssignment)
                ->first();

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
