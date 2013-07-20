<?php

Yii::import('application.modules.deployer.models._base.BaseGithubPayloadCommitUser');

class GithubPayloadCommitUser extends BaseGithubPayloadCommitUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}