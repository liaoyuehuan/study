<?php

class TreeDictionary
{
    private $root;

    public function __construct()
    {
        $this->root = new TreeNode();
    }

    public function insert($word)
    {
        if (false === is_string($word)) {
            throw new RuntimeException('must be string');
        }
        if (empty($word)) {
            return false;
        }
        $node = &$this->root;
        $charArray = $this->toCharArray($word);
        foreach ($charArray as $char) {
            if (isset($node->sonNodes[$char])) {
                $node->sonNodes[$char]->num++;
            } else {
                $node->hasSon = true;
                $node->sonNodes[$char] = new TreeNode();
                $node->sonNodes[$char]->val = $char;
                $node->sonNodes[$char]->num = 1;
            }
            $node = &$node->sonNodes[$char];
        }
        $node->isEnd = true;
        return $this;
    }

    public function search($str)
    {
        $charArray = $this->toCharArray($str);
        unset($str);
        $node = &$this->root;
        $len = count($charArray);
        $hitWordArray = [];
        $hitWord = '';
        $index = 0;
        for ($i = 0; $i < $len; $i++) {
            if (isset($node->sonNodes[$charArray[$i]])) {
                $hitWord .= $node->sonNodes[$charArray[$i]]->val;
                if ($node->sonNodes[$charArray[$i]]->isEnd) {
                    if (isset($hitWordArray[$hitWord])) {
                        $hitWordArray[$hitWord]['num']++;
                    } else {
                        $hitWordArray[$hitWord] = [
                            'word' => $hitWord,
                            'num' => 1
                        ];
                    }
                    if ($node->sonNodes[$charArray[$i]]->hasSon) {
                        $node = &$node->sonNodes[$charArray[$i]];
                    } else {
                        $hitWord = '';
                        $i = $index;
                        $index++;
                        $node = &$this->root;
                    }
                } else {
                    $node = &$node->sonNodes[$charArray[$i]];
                }
            } else {
                $i = $index;
                $index++;
                $node = &$this->root;
                $hitWord = '';
            }
        }
        return $hitWordArray;
    }

    public function countPrefix($prefix)
    {
        $charArray = $this->toCharArray($prefix);
        unset($str);
        $node = $this->root;
        foreach ($charArray as $char) {
            if (isset($node->sonNodes[$char])) {
                $node = &$node->sonNodes[$char];
            } else {
                return 0;
            }
        }
        return $node->num;
    }

    public function preTraverse($prefix)
    {
        $charArray = $this->toCharArray($prefix);
        unset($str);
        $node = $this->root;
        foreach ($charArray as $char) {
            if (isset($node->sonNodes[$char])) {
                $node = &$node->sonNodes[$char];
            } else {
                return [];
            }
        }
        return array_map(function ($value) use ($prefix) {
            return $prefix . $value;
        }, $this->traverseNode($node));
    }

    private function traverseNode(TreeNode $node)
    {

        $wordArray = [];
        if ($node->isEnd) {
            $wordArray[] = '';
        }
        foreach ($node->sonNodes as $sonNode) {
            if ($sonNode->isEnd) {
                $wordArray[] = $sonNode->val;
            }
            if ($sonNode->hasSon) {
                $wordArray = array_merge($wordArray, array_map(function ($value) use ($sonNode) {
                    return $sonNode->val . $value;
                }, $this->traverseNode($sonNode)));
            }
        }
        return $wordArray;
    }

    private function toCharArray($word)
    {
        $len = mb_strlen($word);
        $charArray = [];
        for ($i = 0; $i < $len; $i++) {
            $charArray[] = mb_substr($word, $i, 1);
        }
        return $charArray;
    }
}

class TreeNode
{
    public $num;

    /**
     * @var TreeNode[]
     */
    public $sonNodes;

    public $val;

    public $isEnd;

    public $hasSon;

    public function __construct()
    {
        $this->num = 0;
        $this->sonNodes = [];
        $this->val = null;
        $this->isEnd = false;
        $this->hasSon = false;
    }
}

$wordList = [
    '妈的', '习近平', '胡景涛', '习近', '胡景啊', '胡景了','胡来啊实打实'
];

$tree = new TreeDictionary();
foreach ($wordList as $word) {
    $tree->insert($word);
}

//var_dump($tree);
var_dump($tree->search('你是习近平吗！，是的，我是胡景涛，胡景涛'));

var_dump($tree->countPrefix('胡'));

var_dump($tree->preTraverse('胡'));

