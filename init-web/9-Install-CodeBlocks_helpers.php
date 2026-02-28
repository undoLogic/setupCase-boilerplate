<?php

$appViewFile = dirname(__DIR__) . '/sourceFiles/src/View/AppView.php';

if (!file_exists($appViewFile)) {
    echo "ERROR - AppView.php not found";
    exit;
}

$contents = file_get_contents($appViewFile);

if ($contents === false) {
    echo "ERROR - Could not read AppView.php";
    exit;
}

$contents = str_replace(["\r\n", "\r"], "\n", $contents);
$updated = false;

if (strpos($contents, "\$this->loadHelper('Auth');") === false) {
    if (strpos($contents, 'public function initialize(): void') !== false) {
        $contents = str_replace(
            "    public function initialize(): void\n    {\n",
            "    public function initialize(): void\n    {\n        \$this->loadHelper('Auth');\n",
            $contents,
            $count
        );
        if ($count !== 1) {
            echo "ERROR - initialize method anchor for Auth helper not found";
            exit;
        }
    } else {
        echo "ERROR - initialize method not found";
        exit;
    }
    $updated = true;
}

if (strpos($contents, "\$this->loadHelper('Lang');") === false) {
    if (strpos($contents, "\$this->loadHelper('Auth');\n") !== false) {
        $contents = str_replace(
            "\$this->loadHelper('Auth');\n",
            "\$this->loadHelper('Auth');\n        \$this->loadHelper('Lang');\n",
            $contents,
            $count
        );
        if ($count !== 1) {
            echo "ERROR - Auth helper anchor for Lang helper not found";
            exit;
        }
    } elseif (strpos($contents, 'public function initialize(): void') !== false) {
        $contents = str_replace(
            "    public function initialize(): void\n    {\n",
            "    public function initialize(): void\n    {\n        \$this->loadHelper('Lang');\n",
            $contents,
            $count
        );
        if ($count !== 1) {
            echo "ERROR - initialize method anchor for Lang helper not found";
            exit;
        }
    } else {
        echo "ERROR - initialize method not found";
        exit;
    }
    $updated = true;
}

if (!$updated) {
    echo "AppView helpers already exist — skipping<br/>";
    exit;
}

file_put_contents($appViewFile, $contents);

echo "AppView helpers added successfully<br/><br/>";
