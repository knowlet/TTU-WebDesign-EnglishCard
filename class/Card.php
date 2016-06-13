<?php

class Card
{
    public function addCard($vocabulary, $definition=[], $example=[])
    {
        $user = (new Session)->auth['username'];
        $userId = (new Session)->auth['uid'];
        $cardId = $this->isExist($vocabulary)['id'];
        if(empty($cardId))
        {
            (new Database)->Update("INSERT INTO `vocabularies` (words) VALUES (?)", [$vocabulary]);
            $cardId = $this->isExist($vocabulary)['id'];
        }

        if(!(new Database)->Query("SELECT * FROM `vocabLists` WHERE vid = ? AND uid = ?", [$cardId, $userId]))
            (new Database)->Update("INSERT INTO `vocabLists` (uid, vid) VALUES (?, ?)", [$userId, $cardId]);

        $count = (new Database)->Query("SELECT MAX(`defId`) FROM `definitions` WHERE vocabId = ? GROUP BY vocabId", [$cardId]);
        if (empty($count)) 
            $count = 1;
        else
            $count = intval($count) + 1;
        foreach (array_combine($definition, $example) as $d => $ex)
        {
            try {
                if((new Database)->Query("SELECT * FROM `definitions` WHERE definition = ?", [$d]))
                    throw new Exception('解釋重複');
                if((new Database)->Query("SELECT * FROM `examples` WHERE example = ?", [$ex]))
                    throw new Exception('範例重複');
                
                (new Database)->Update("INSERT INTO `definitions` (vocabId, defId, definition) VALUES (?, ?, ?)", [$cardId, $count, $d]);
                (new Database)->Update("INSERT INTO `examples` (vocabId, exId, example) VALUES (?, ?, ?)", [$cardId, $count, $ex]);

            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                        
            }
            $count++;
        }
    }

    public function delCard($vocabulary)
    {
        $user = (new Session)->auth['username'];
        $cardId = $this->isExist($vocabulary)['id'];

        if(!empty($cardId))
        {
            (new Database)->Update("DELETE FROM `vocabLists` WHERE uid = ? AND vid = ?", [$userId, $cardId]);
        }
    }

    protected function isExist($vocabulary)
    {
        return (new Database)->Query("SELECT * FROM `vocabularies` WHERE words = ?", [$vocabulary]);
    }

    public function getCard($vocabularyId)
    {
        $name = (new Database)->Query("SELECT * FROM `vocabularies` WHERE id = ?", [$vocabularyId])['words'];
        $definitions = (new Database)->QueryAll("SELECT `definition` FROM `definitions` WHERE vocabId = ? ORDER BY `defId`", [$vocabularyId]);
        $examples = (new Database)->QueryAll("SELECT `example` FROM `examples` WHERE vocabId = ? ORDER BY `exId`", [$vocabularyId]);

        foreach ($definitions as $key => $value)
        {
            $definitions[$key] = $value[0];
        }
        foreach ($examples as $key => $value)
        {
            $examples[$key] = $value[0];
        }
        
        return [$name, $definitions, $examples];
    }

    public function getVocabularyList()
    {
        $user = (new Session)->auth['username'];
        $userId = (new Session)->auth['uid'];
        return (new Database)->QueryAll("SELECT vid FROM vocabLists WHERE uid = ? ", [$userId]);
    }
}
