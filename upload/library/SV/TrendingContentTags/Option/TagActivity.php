<?php

class SV_TrendingContentTags_Option_TagActivity
{
    public static function renderOption(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        $activities = explode("\n", $preparedOption['sub_options']);
        $defaults = unserialize($preparedOption['default_value']);

        $options = array();
        foreach($activities as $activity)
        {
            if (stripos($activity, 'w_') === 0)
            {
                continue;
            }
            $activity_w = 'w_'.$activity;
            $options[] = array(
                'name' => htmlspecialchars($fieldPrefix . "[$preparedOption[option_id]][$activity]"),
                'name_w' => htmlspecialchars($fieldPrefix . "[$preparedOption[option_id]][$activity_w]"),
                'selected' => !empty($preparedOption['option_value'][$activity]),
                'label' => new XenForo_Phrase('tag_activity_'.$activity),
                'value' => isset($preparedOption['option_value'][$activity_w]) ? $preparedOption['option_value'][$activity_w] : '',
                'placeholder' => isset($defaults[$activity_w]) ? $defaults[$activity_w] : '',
                'maxlength' => 5,
                'size' => 5,
            );
        }

        $preparedOption['formatParams'] = $options;

        return XenForo_ViewAdmin_Helper_Option::renderOptionTemplateInternal(
            'option_tag_activity_select', $view, $fieldPrefix, $preparedOption, $canEdit
        );
    }
}