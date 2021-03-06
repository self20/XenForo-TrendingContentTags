<?php

class SV_TrendingContentTags_XenForo_ControllerPublic_Forum extends XFCP_SV_TrendingContentTags_XenForo_ControllerPublic_Forum
{
    public function actionIndex()
    {
        $response = parent::actionIndex();
        if ($response instanceof XenForo_ControllerResponse_View)
        {
            $options = XenForo_Application::getOptions();
            if ($options->sv_tagTrending['enabled'])
            {
                $tagModel = $this->_getTagModel();
                $tagCloud = $tagModel->getTrendingTagCloud($options->sv_tagTrending['count'], $options->sv_tagTrendingMinActivity, $options->sv_tagTrendingMinCount, $options->sv_tagTrendingWindow * 60);
                $tagCloudLevels = $tagModel->getTrendingTagCloudLevels($tagCloud);
            }
            else
            {
                $tagCloud = array();
                $tagCloudLevels = array();
            }
            $response->params['tagCloud'] = $tagCloud;
            $response->params['tagCloudLevels'] = $tagCloudLevels;
        }
        return $response;
    }

    protected function _getTagModel()
    {
        return $this->getModelFromCache('XenForo_Model_Tag');
    }
}