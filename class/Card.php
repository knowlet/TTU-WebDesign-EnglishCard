<?php

class Card
{

    public function addCard($vocabulary, $definition=[], $example=[])
    {
        $user = (new Session)->auth['username'];
        $userId = (new Database)->Query("SELECT `uid` FROM `users` WHERE username = ?", [$user])[0][0];
        $cardId = $this->getCard($vocabulary);
        if(empty($cardId))
        {
            (new Database)->Update("INSERT INTO `vocabularies` (id, words) VALUES (?, ?)", [NULL, $vocabulary]);
            $cardId = $this->getCard($vocabulary);
        }
        (new Database)->Update("INSERT INTO `vocabLists` (uid, vid) VALUES (?, ?)", [$userId, $cardId]);
        
        $count = 1;
        foreach (array_combine($definition, $example) as $d => $ex) 
        {
            # add check exist?
            (new Database)->Update("INSERT INTO `definitions` (vocabId, defId, definition) VALUES (?, ?, ?)", [$cardId, $count, $d]);
            (new Database)->Update("INSERT INTO `examples` (vocabId, exId, example) VALUES (?, ?, ?)", [$cardId, $count, $ex]);
            $count++;
        }
    }

    public static function delCard($vocabulary)
    {
        $user = (new Session)->auth['username'];
        $cardId = $this->getCard($vocabulary);

        if(!empty($cardId))
        {
            (new Database)->Update("DELETE FROM `vocabLists` WHERE uid = ? AND vid = ?", [$userId, $cardId]);
        }
    }

    protected function getCard($vocabulary)
    {
        return (new Database)->Query("SELECT `id` FROM `vocabularies` WHERE words = ?", [$vocabulary])[0][0];
    }
}
