<?php
class Events_New_Block extends Template_Block {
    function content($limit = null) {
        if(is_null($limit)) {
            $limit = intval($this->PMDR->getConfig('block_events_new_number'));
        }
        if($limit) {
            $block_template = $this->PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.'blocks/block_events_new.tpl');
            $block_template->cache_id = 'block_events_new'.$limit;
            $block_template->expire = 900;
            if(!$block_template->isCached()) {
                $results = $this->PMDR->get('Events')->getNew($limit);
                if(is_array($results) AND sizeof($results) > 0) {
                    foreach($results as $key=>$value) {
                        $results[$key]['description_short'] = Strings::limit_words($value['description_short'], $this->PMDR->getConfig('block_description_size'));
                    }
                    $block_template->set('events',$results);
                }
            }
            return $block_template;
        }
    }
}
?>