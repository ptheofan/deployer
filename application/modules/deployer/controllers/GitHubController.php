<?php
/**
 * User: Paris Theofanidis
 * Date: 20/07/2013
 * Time: 2:01 AM
 */

class GitHubController extends CController {
    public function actionPayload() {
        $payload = $this->getParam('payload');
        CVarDumper::dump($payload,10,true);die;
    }
}