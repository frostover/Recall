<?php

class Set extends Model {
    public function get_vocabularies() {
        return $this->has_many('Vocabulary')->order_by_asc('id');
    }

    public function get_new_vocabularies() {
        $max = Setting::get('new_vocabs_per_day') - Vocabulary::filter('learned_today')->count();
        $sets = Vocabulary::filter('inactive')->select('set_id')->limit($max)->distinct()->find_many();

        if (count($sets) == 0 || !in_array($this->id, array_map(function($x) { return $x->set_id; }, $sets))) return [];

        $limit = round($max / count($sets));
        return Set::get_vocabularies()->filter('inactive')->limit($limit)->find_many();
    }

    public function get_due_count() {
        return $this->get_vocabularies()->filter('due')->count();
    }

    public function get_permalink() {
        return BASE_PATH . 'set/' . $this->id;
    }
}
