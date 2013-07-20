<?php

Yii::import('application.modules.deployer.models._base.BaseGithubPayloadCommitFile');

class GithubPayloadCommitFile extends BaseGithubPayloadCommitFile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}