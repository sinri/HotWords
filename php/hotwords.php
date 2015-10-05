<?php
/**
 *
 * @author Sinri
 *
 * Just use static function `wordNormalize` to get word stem.
 * 
 * ORIGINAL DECLARATION OF PORTER STEMMER CODES
 * 
 * Porter stemmer in Java. The original paper is in
 *
 * Porter, 1980, An algorithm for suffix stripping, Program, Vol. 14, no. 3, pp
 * 130-137,
 *
 * See also http://www.tartarus.org/~martin/PorterStemmer
 *
 * History:
 *
 * Release 1
 *
 * Bug 1 (reported by Gonzalo Parra 16/10/99) fixed as marked below. The words
 * 'aed', 'eed', 'oed' leave k at 'a' for step 3, and b[k-1] is then out outside
 * the bounds of b.
 *
 * Release 2
 *
 * Similarly,
 *
 * Bug 2 (reported by Steve Dyrdahl 22/2/00) fixed as marked below. 'ion' by
 * itself leaves j = -1 in the test for 'ion' in step 5, and b[j] is then
 * outside the bounds of b.
 *
 * Release 3
 *
 * Considerably revised 4/9/00 in the light of many helpful suggestions from
 * Brian Goetz of Quiotix Corporation (brian@quiotix.com).
 *
 * Release 4
 *
 */
class HotWords {

    private $b='';//char[]
    private $i=0;//int  /* offset into b */
    private $i_end=0;//int /* offset to end of stemmed word */
    private $j=0;//int
    private $k=0;//int
    private static $INC = 50;//int 
    /* unit of size whereby b is increased */

    function __construct() {
        $this->b = "";//new char[INC];
        $this->i = 0;
        $this->i_end = 0;
    }

    /**
     * Add a character to the word being stemmed. When you are finished adding
     * characters, you can call stem(void) to stem the word.
     */
    public function add($ch) {//void(char ch)
//        if ($this->i == strlen($this->b)) {
//            In PHP String is not length-limited
//            char[] new_b = new char[i + INC];
//            System.arraycopy(b, 0, new_b, 0, i);
//            b = new_b;
//        }
        $this->b.=$ch;
        $this->i+=strlen($ch);
    }

    /**
     * After a word has been stemmed, it can be retrieved by toString(), or a
     * reference to the internal buffer can be retrieved by getResultBuffer and
     * getResultLength (which is generally more efficient.)
     */
    public function toString() {
//        return new String(b, 0, i_end);
        return substr($this->b,0,$this->i_end);
    }

    /**
     * Returns the length of the word resulting from the stemming process.
     */
    public function getResultLength() { //int()
        return $this->i_end;
    }

    /**
     * Returns a reference to a character buffer containing the results of the
     * stemming process. You also need to consult getResultLength() to determine
     * the length of the result.
     */
    public function getResultBuffer() { //char[]()
        return $this->b;
    }

    /* cons(i) is true <=> b[i] is a consonant. */
    private function cons($i) {//boolean(int i)
        $bi=substr($this->b,$i,1);
        switch ($bi) {
            case 'a':
            case 'e':
            case 'i':
            case 'o':
            case 'u':
                return false;
            case 'y':
                return ($i == 0) ? true : !$this->cons($i - 1);
            default:
                return true;
        }
    }

    /* m() measures the number of consonant sequences between 0 and j. if c is
     a consonant sequence and v a vowel sequence, and <..> indicates arbitrary
     presence,

     <c><v>       gives 0
     <c>vc<v>     gives 1
     <c>vcvc<v>   gives 2
     <c>vcvcvc<v> gives 3
     ....
     */
    private function m() {//int()
        $n = 0;//int
        $inner_i = 0;//int
        while (true) {
            if ($inner_i > $this->j) {
                return $n;
            }
            if (!$this->cons($inner_i)) {
                break;
            }
            $inner_i++;
        }
        $inner_i++;
        while (true) {
            while (true) {
                if ($inner_i > $this->j) {
                    return $n;
                }
                if ($this->cons($inner_i)) {
                    break;
                }
                $inner_i++;
            }
            $inner_i++;
            $n++;
            while (true) {
                if ($inner_i > $this->j) {
                    return $n;
                }
                if (!$this->cons($inner_i)) {
                    break;
                }
                $inner_i++;
            }
            $inner_i++;
        }
    }

    /* vowelinstem() is true <=> 0,...j contains a vowel */
    private function vowelinstem() {//boolean()
        $inner_i=0;//int
        for ($inner_i = 0; $inner_i <= $this->j; $inner_i++) {
            if (!$this->cons($inner_i)) {
                return true;
            }
        }
        return false;
    }

    /* doublec(j) is true <=> j,(j-1) contain a double consonant. */
    private function doublec($j) {//boolean(int j)
        if ($j < 1) {
            return false;
        }
        if (substr($this->b,$j,1) != substr($this->b,$j-1,1)) {
            return false;
        }
        return $this->cons($j);
    }

    /* cvc(i) is true <=> i-2,i-1,i has the form consonant - vowel - consonant
     and also if the second c is not w,x or y. this is used when trying to
     restore an e at the end of a short word. e.g.

     cav(e), lov(e), hop(e), crim(e), but
     snow, box, tray.

     */
    private function cvc($i) {//boolean(int i)
        if ($i < 2 || !$this->cons($i) || $this->cons($i - 1) || !$this->cons($i - 2)) {
            return false;
        }
        {
            $ch = substr($this->b,$i,1);
            if ($ch == 'w' || $ch == 'x' || $ch == 'y') {
                return false;
            }
        }
        return true;
    }

    private function ends($s) {//boolean(String s)
        $l=strlen($s);//int l = s.length();
        $o=$this->k-$l+1;//int o = k - l + 1;
        if ($o < 0) {
            return false;
        }
        for ($inner_i = 0; $inner_i < $l; $inner_i++) {
            if (substr($this->b,$o + $inner_i,1) != substr($s,$inner_i,1)) {
                return false;
            }
        }
        $this->j = $this->k - $l;
        return true;
    }

    /* setto(s) sets (j+1),...k to the characters in the string s, readjusting
     k. */
    private function setto($s) {//void(String s)
        $l=strlen($s);//int l = s.length();
        $o=$this->j+1;//int o = j + 1;
        for ($inner_i = 0; $inner_i < $l; $inner_i++) {
            substr_replace($this->b,substr($s,$inner_i,1),$o + $inner_i,1);
        }
        $this->k = $this->j + $l;
    }

    /* r(s) is used further down. */
    private function r($s) {//void(String s)
        if ($this->m() > 0) {
            $this->setto($s);
        }
    }

    /* step1() gets rid of plurals and -ed or -ing. e.g.

     caresses  ->  caress
     ponies    ->  poni
     ties      ->  ti
     caress    ->  caress
     cats      ->  cat

     feed      ->  feed
     agreed    ->  agree
     disabled  ->  disable

     matting   ->  mat
     mating    ->  mate
     meeting   ->  meet
     milling   ->  mill
     messing   ->  mess

     meetings  ->  meet

     */
    private function step1() {
        if (substr($this->b,$this->k,1) == 's') {
            if ($this->ends("sses")) {
                $this->k -= 2;
            } else if ($this->ends("ies")) {
                $this->setto("i");
            } else if (substr($this->b,$this->k - 1,1) != 's') {
                $this->k--;
            }
        }
        if ($this->ends("eed")) {
            if ($this->m() > 0) {
                $this->k--;
            }
        } else if (($this->ends("ed") || $this->ends("ing")) && $this->vowelinstem()) {
            $this->k = $this->j;
            if ($this->ends("at")) {
                $this->setto("ate");
            } else if ($this->ends("bl")) {
                $this->setto("ble");
            } else if ($this->ends("iz")) {
                $this->setto("ize");
            } else if ($this->doublec($this->k)) {
                $this->k--;
                {
                    $ch=substr($this->b,$this->k,1);//int ch = b[k];
                    if ($ch == 'l' || $ch == 's' || $ch == 'z') {
                        $this->k++;
                    }
                }
            } else if ($this->m() == 1 && $this->cvc($this->k)) {
                $this->setto("e");
            }
        }
    }

    /* step2() turns terminal y to i when there is another vowel in the stem. */
    private function step2() {
        if ($this->ends("y") && $this->vowelinstem()) {
            substr_replace($this->b,'i',$this->k,1);//b[k] = 'i';
        }
    }

    /* step3() maps double suffices to single ones. so -ization ( = -ize plus
     -ation) maps to -ize etc. note that the string before the suffix must give
     m() > 0. */
    private function step3() {
        if ($this->k == 0) {
            return;
        } /* For Bug 1 */ 
        $bk=substr($this->b,$this->k-1,1);
        switch ($bk) {
            case 'a':
                if ($this->ends("ational")) {
                    $this->r("ate");
                    break;
                }
                if ($this->ends("tional")) {
                    $this->r("tion");
                    break;
                }
                break;
            case 'c':
                if ($this->ends("enci")) {
                    $this->r("ence");
                    break;
                }
                if ($this->ends("anci")) {
                    $this->r("ance");
                    break;
                }
                break;
            case 'e':
                if ($this->ends("izer")) {
                    $this->r("ize");
                    break;
                }
                break;
            case 'l':
                if ($this->ends("bli")) {
                    $this->r("ble");
                    break;
                }
                if ($this->ends("alli")) {
                    $this->r("al");
                    break;
                }
                if ($this->ends("entli")) {
                    $this->r("ent");
                    break;
                }
                if ($this->ends("eli")) {
                    $this->r("e");
                    break;
                }
                if ($this->ends("ousli")) {
                    $this->r("ous");
                    break;
                }
                break;
            case 'o':
                if ($this->ends("ization")) {
                    $this->r("ize");
                    break;
                }
                if ($this->ends("ation")) {
                    $this->r("ate");
                    break;
                }
                if ($this->ends("ator")) {
                    $this->r("ate");
                    break;
                }
                break;
            case 's':
                if ($this->ends("alism")) {
                    $this->r("al");
                    break;
                }
                if ($this->ends("iveness")) {
                    $this->r("ive");
                    break;
                }
                if ($this->ends("fulness")) {
                    $this->r("ful");
                    break;
                }
                if ($this->ends("ousness")) {
                    $this->r("ous");
                    break;
                }
                break;
            case 't':
                if ($this->ends("aliti")) {
                    $this->r("al");
                    break;
                }
                if ($this->ends("iviti")) {
                    $this->r("ive");
                    break;
                }
                if ($this->ends("biliti")) {
                    $this->r("ble");
                    break;
                }
                break;
            case 'g':
                if ($this->ends("logi")) {
                    $this->r("log");
                    break;
                }
        }
    }

    /* step4() deals with -ic-, -full, -ness etc. similar strategy to step3. */
    private function step4() {
        $bk=substr($this->b,$this->k,1);
        switch ($bk) {
            case 'e':
                if ($this->ends("icate")) {
                    $this->r("ic");
                    break;
                }
                if ($this->ends("ative")) {
                    $this->r("");
                    break;
                }
                if ($this->ends("alize")) {
                    $this->r("al");
                    break;
                }
                break;
            case 'i':
                if ($this->ends("iciti")) {
                    $this->r("ic");
                    break;
                }
                break;
            case 'l':
                if ($this->ends("ical")) {
                    $this->r("ic");
                    break;
                }
                if ($this->ends("ful")) {
                    $this->r("");
                    break;
                }
                break;
            case 's':
                if ($this->ends("ness")) {
                    $this->r("");
                    break;
                }
                break;
        }
    }

    /* step5() takes off -ant, -ence etc., in context <c>vcvc<v>. */
    private function step5() {
        if ($this->k == 0) {
            return;
        } /* for Bug 1 */ 
        $bk=substr($this->b,$this->k-1,1);
        switch ($bk) {
            case 'a':
                if ($this->ends("al")) {
                    break;
                }
                return;
            case 'c':
                if ($this->ends("ance")) {
                    break;
                }
                if ($this->ends("ence")) {
                    break;
                }
                return;
            case 'e':
                if ($this->ends("er")) {
                    break;
                }
                return;
            case 'i':
                if ($this->ends("ic")) {
                    break;
                }
                return;
            case 'l':
                if ($this->ends("able")) {
                    break;
                }
                if ($this->ends("ible")) {
                    break;
                }
                return;
            case 'n':
                if ($this->ends("ant")) {
                    break;
                }
                if ($this->ends("ement")) {
                    break;
                }
                if ($this->ends("ment")) {
                    break;
                }
                /* element etc. not stripped before the m */
                if ($this->ends("ent")) {
                    break;
                }
                return;
            case 'o':
                if ($this->ends("ion") && $this->j >= 0 && (substr($this->b,$this->j,1) == 's' || substr($this->b,$this->j,1) == 't')) {
                    break;
                }
                /* j >= 0 fixes Bug 2 */
                if ($this->ends("ou")) {
                    break;
                }
                return;
            /* takes care of -ous */
            case 's':
                if ($this->ends("ism")) {
                    break;
                }
                return;
            case 't':
                if ($this->ends("ate")) {
                    break;
                }
                if ($this->ends("iti")) {
                    break;
                }
                return;
            case 'u':
                if ($this->ends("ous")) {
                    break;
                }
                return;
            case 'v':
                if ($this->ends("ive")) {
                    break;
                }
                return;
            case 'z':
                if ($this->ends("ize")) {
                    break;
                }
                return;
            default:
                return;
        }
        if ($this->m() > 1) {
            $this->k = $this->j;
        }
    }

    /* step6() removes a final -e if m() > 1. */
    private function step6() {
        $this->j = $this->k;
        if (substr($this->b,$this->k,1) == 'e') {
            $a = $this->m();
            if ($a > 1 || $a == 1 && !$this->cvc($this->k - 1)) {
                $this->k--;
            }
        }
        if (substr($this->b,$this->k,1) == 'l' && $this->doublec($this->k) && $this->m() > 1) {
            $this->k--;
        }
    }

    /**
     * Stem the word placed into the Stemmer buffer through calls to add().
     * Returns true if the stemming process resulted in a word different from
     * the input. You can retrieve the result with
     * getResultLength()/getResultBuffer() or toString().
     */
    public function stem() {
        $this->k = $this->i - 1;
        if ($this->k > 1) {
            $this->step1();
            $this->step2();
            $this->step3();
            $this->step4();
            $this->step5();
            $this->step6();
        }
        $this->i_end = $this->k + 1;
        $this->i = 0;
    }
    
    public static function wordNormalize($anyword){//String(String anyword)
        $s = new HotWords();
        
//        $s.add(anyword.toCharArray(), anyword.length());
        $s->add($anyword);
        
        $s->stem();
        
        return $s->toString();
    }
}
//TEST

function testForHotWordStem(){
    $ts=array('apple','apples','apply','applies','application','applications','applicate',);
    foreach ($ts as $t) {
        echo $t.' -> '.HotWords::wordNormalize($t).PHP_EOL;
    }
}

?>