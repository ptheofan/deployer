<?php

Yii::import('application.modules.deployer.models._base.BaseGithubUser');

class GithubUser extends BaseGithubUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}