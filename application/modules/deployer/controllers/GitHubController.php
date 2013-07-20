<?php
/**
 * User: Paris Theofanidis
 * Date: 20/07/2013
 * Time: 2:01 AM
 */

class GitHubController extends CController {
    public function actionPayload() {
        $payload = Yii::app()->request->getParam('payload');
        if (!$payload) {
            // log error - missing payload parameter
        }

        $payload = json_decode($payload);
        if ($payload === null) {
            // log error - cannot json decode the payload
        }

        $githubPayload = new GithubPayload();

    }
}