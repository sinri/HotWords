/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hotwords;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.TreeMap;
import java.util.stream.Stream;

/**
 *
 * @author Sinri
 */
public class HotWords {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException {
        // TODO code application logic here
//        testForStem();
        
        InputStreamReader isr = new InputStreamReader(System.in);
        BufferedReader br = new BufferedReader(isr);

        HashMap<String, String> wordMap = new HashMap<>();
        TreeMap<String, Integer> wordStemStat = new TreeMap<>();

        System.out.println("Input your text, from which hot words would be sought. End with an empty line, i.e. just an ENTER press. ^_^");

        while (true) {
            String line = br.readLine();
//            System.out.println("[Read]"+line+" Length = "+line.toCharArray().length);
            if (line.matches("[\\s]*")) {
                System.out.println("[EMPTY LINE, OVER]");
                break;
            }
            String[] split = line.split("[^a-zA-Z]+");
            for (String s0 : split) {
                String s = s0.toLowerCase();
                String stem = Stemmer.wordNormalize(s);
                if (!wordMap.containsKey(stem)) {
                    wordMap.put(stem, s);
                } else {
                    if (wordMap.get(stem).length() > s.length()) {
                        wordMap.put(stem, s);
                    }
                }
                if (!wordStemStat.containsKey(stem)) {
                    wordStemStat.put(stem, 1);
                } else {
                    wordStemStat.put(stem, wordStemStat.get(stem) + 1);
                }
            }
        }
        
        Map<String, Integer> sorted = sortByValue(wordStemStat);

        ArrayList<String> keys=new ArrayList<>();
        sorted.keySet().forEach((key)->{
            keys.add(key);
        });
        
        System.out.println("[CONCLUSION]");
        Reversed.reversed(keys).forEach((key) -> {
            System.out.println("["+key + "] Counts " + wordStemStat.get(key) + " Original Word: " + wordMap.get(key));
        });
    }

    public static <K, V extends Comparable<? super V>> Map<K, V> sortByValue(Map<K, V> map) {
        Map<K, V> result = new LinkedHashMap<>();
        Stream<Entry<K, V>> st = map.entrySet().stream();

        st.sorted(Comparator.comparing(e -> e.getValue()))
                .forEach(e -> result.put(e.getKey(), e.getValue()));

        return result;
    }

    public static void testForStem() {
        ArrayList<String> array = new ArrayList<>();
        array.add("apples");
        array.add("apple");
        array.add("Apple");
        array.add("apply");
        array.add("applies");
        array.add("application");

        array.stream().forEach((s1) -> {
            System.out.println(s1 + " => " + Stemmer.wordNormalize(s1));
        });
    }
}
