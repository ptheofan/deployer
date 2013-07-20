<?php

Yii::import('application.modules.deployer.models._base.BaseGithubRepository');

class GithubRepository extends BaseGithubRepository
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}