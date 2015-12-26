<?php
namespace App\Repositories;

use App\KnowledgeUnit;

class KnowledgeUnitRepository
{
    /**
     * Get all of the knowledge units for a given topic.
     *
     * @param  Topic  $topic
     * @return Collection
     */
    public function forTopic($topic_id)
    {
        return KnowledgeUnit::with("questions")
            ->where('knowledge_units.topic_id', $topic_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}