<?php

Yii::import('application.modules.deployer.models._base.BaseGithubPayload');

class GithubPayload extends BaseGithubPayload
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}