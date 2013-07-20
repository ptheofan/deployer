<?php

Yii::import('application.modules.deployer.models._base.BaseGithubPayloadCommit');

class GithubPayloadCommit extends BaseGithubPayloadCommit
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}