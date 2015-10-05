/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hotwords;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.HashMap;
import java.util.HashSet;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.TreeMap;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.stream.Stream;

/**
 *
 * @author Sinri
 */
public class HotWords {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
//        System.out.println(args.length);//From 0
        if (args.length <= 0) {
            System.out.println("To analyze text in a file, use command as below:\n"
                    + "java -jar HotWords.jar [FILE] [FILTER] [LEAST] [LIMIT]\n"
                    + "FILE: the path to the target file;\n"
                    + "FILTER: none or common (neglect the preset 1000 words in common use);\n"
                    + "LEAST: the least times should a word appears;\n"
                    + "LIMIT: the most frequent words;\n"
                    + "Now into interactive mode.\n");
            HotWords.kaiwaMode();
        } else {
            String filepath = null;
            String filter_name="none";
            int least = 1;
            int limit = 0;

            filepath = args[0];

            if (args.length > 1) {
                filter_name = (args[1]);
            }
            if (args.length > 2) {
                least = Integer.parseInt(args[2]);
            }
            if (args.length > 3) {
                limit = Integer.parseInt(args[3]);
            }

            HotWords.jidouMode(filepath,filter_name, least, limit);
        }

    }

    public static void jidouMode(String filepath,String filter_name, int least, int limit) {
        try {
            File file = new File(filepath);
            FileInputStream fis = new FileInputStream(file);
            InputStreamReader isr = new InputStreamReader(fis);
            BufferedReader br = new BufferedReader(isr);

            HashMap<String, HashSet<String>> wordMap = new HashMap<>();
            TreeMap<String, Integer> wordStemStat = new TreeMap<>();

            while (true) {
                String line = br.readLine();
                if (line == null) {
                    break;
                }
                String[] split = line.split("[^a-zA-Z]+");
                for (String s0 : split) {
                    String s = s0.trim().toLowerCase();
                    if(s==null || s.isEmpty())continue;
                    if(filter_name.equalsIgnoreCase("common") && Filter.getInstance().isCommonWord(s))continue;
                    String stem = Stemmer.wordNormalize(s);
                    if (!wordMap.containsKey(stem)) {
                        HashSet<String> hs = new HashSet<>();
                        hs.add(s0);
                        wordMap.put(stem, hs);
                    } else {
                        HashSet<String> hs = wordMap.get(stem);
                        hs.add(s0);
                    }
                    if (!wordStemStat.containsKey(stem)) {
                        wordStemStat.put(stem, 1);
                    } else {
                        wordStemStat.put(stem, wordStemStat.get(stem) + 1);
                    }
                }
            }

            Map<String, Integer> sorted = sortByValue(wordStemStat);

            ArrayList<String> keys = new ArrayList<>();
            sorted.keySet().forEach((key) -> {
                keys.add(key);
            });

            System.out.println("[CONCLUSION]");
            int show_order = 0;
            int show_count = 0;
            int hide_order = 0;

            for (int i = keys.size() - 1; i > 0; i--) {
                String key = keys.get(i);
                hide_order++;
                if (show_order == 0 || show_count != wordStemStat.get(key)) {
                    show_order = hide_order;
                    show_count = wordStemStat.get(key);
                    if (limit > 0 && show_order > limit) {
                        return;
                    }
                }
                System.out.println("[" + key + "] Counts " + wordStemStat.get(key) + " Original Word: " + wordMap.get(key));
            }

        } catch (FileNotFoundException ex) {
            Logger.getLogger(HotWords.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(HotWords.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public static void kaiwaMode() {
        try {
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

            ArrayList<String> keys = new ArrayList<>();
            sorted.keySet().forEach((key) -> {
                keys.add(key);
            });

            System.out.println("[CONCLUSION]");
            Reversed.reversed(keys).forEach((key) -> {
                System.out.println("[" + key + "] Counts " + wordStemStat.get(key) + " Original Word: " + wordMap.get(key));
            });
        } catch (Exception e) {

        }
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
