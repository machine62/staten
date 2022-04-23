<?php

class my_abstractstaten  {

    protected $isEnd = false; 
    protected $winner = "-"; 

   protected function setWinner($winnerID)
   {
       $this->winner = $winnerID;
   }
    protected function setIsEnd($isEnd)
   {
         $this->isEnd =$isEnd;
   }

    public function getWinner() {
     
        return $this->winner;
    }

    public function isEnd() {
        return $this->isEnd;
    }
    


}
