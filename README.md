# HotWords

A corpus analysis tool for concordancing and text analysis.

The main function is to extract high-frequency words from a text.

The toolkit is designed for English Education. It can lessen the barriers for reading by knowing those words in advance.

## 20151006 JAR

To analyze text in a file, use command as below:

    java -jar HotWords.jar [FILE] [FILTER] [LEAST] [LIMIT]

> FILE: the path to the target file;
> FILTER: none or common (neglect the preset 1000 words in common use);
> LEAST: the least times should a word appears;
> LIMIT: the most frequent words;

Example:

    SinriMac:dist Sinri$ java -jar HotWords.jar README.TXT common 5 3
    [CONCLUSION]
    [file] Counts 10 Original Word: [file, files]
    [jar] Counts 8 Original Word: [JAR, jar]
    [folder] Counts 8 Original Word: [folder, folders]


## 20151005 PHP

Rewrote the function into PHP. 

You can do the same job on this [Interactive Page](http://www.everstray.com/hotwords/) now.

You can choose to use Word Filter(Most Frequent 1000 words) or not. Also Least Frequency and Top Limitation(0 for all) are available now.

## 20151005 Mimei

Run in NetBeans Terminal

    Input your text, from which hot words would be sought. End with an empty line, i.e. just an ENTER press. ^_^
    We might just glance at the progress of that testimony in the Old Testament as the Lord Himself divided it - Moses, the Psalms, and the Prophets - not by any means to deal with the content of those three sections, but to take account simply of the fact that the testimony of Jesus was there in all. As we saw in chapter three in speaking somewhat along these lines from Hebrews chapter 11, the testimony was progressive through those ages and dispensations, taking the broader view than that of the letter to the Hebrews which has to do with persons. The broader view here has to do with the whole stretch of Scripture. You have Moses, representing the first section of the Scriptures, and in that first section of the Scriptures as gathered up into and under Moses, we have the testimony of Jesus figuratively presented. Everything is gathered up from the patriarchs into a corporate expression, a collective representation in the tabernacle coming in with Exodus 35 - the testimony of Jesus figuratively presented and Moses is, so to speak, the figurehead, and Moses is called a prophet. If you look at Acts chapter 7, in Stephen's mighty and marvellous discourse in chapter seven, when you get to verse 37 you find the climax to a section of his argument: "This is that Moses, which said unto the children of Israel, A prophet shall the Lord your God raise up unto you of your brethren, like unto me." That does not mean, as the margin makes clear, that Christ would be like Moses. The margin says: "As He raised me up". "He will raise up a prophet as He raised me up." In his representative character of that whole figurative system, Moses was a prophet pointing on, prophesying of that which was to come, and the spirit of prophecy in that whole system gathered up into Moses was pointing on to Christ. Of course we know very well how everything in Moses did speak of Christ. Every detail of that representation spoke of Christ and of the spiritual principles represented by those who had been the predecessors of Moses in the covenant line; they were now collected into a whole in Moses and the tabernacle. The blood of Abel is there, the walk with God of Enoch is there, the ground of a new covenant in resurrection in Noah is there, and all that Abraham stands for is there; all gathered up collectively, but it all points on prophetically to the Lord Jesus.

    [EMPTY LINE, OVER]
    [CONCLUSION]
    [the] Counts 36 Original Word: the
    [of] Counts 25 Original Word: of
    [in] Counts 16 Original Word: in
    [that] Counts 12 Original Word: that
    [mose] Counts 12 Original Word: moses
    [to] Counts 11 Original Word: to
    [and] Counts 11 Original Word: and
    [a] Counts 9 Original Word: a
    [up] Counts 8 Original Word: up
    [is] Counts 8 Original Word: is
    [prophet] Counts 6 Original Word: prophet
    [as] Counts 6 Original Word: as
    [you] Counts 5 Original Word: you
    [with] Counts 5 Original Word: with
    [wa] Counts 5 Original Word: was
    [there] Counts 5 Original Word: there
    [testimoni] Counts 5 Original Word: testimony
    [whole] Counts 4 Original Word: whole
    [we] Counts 4 Original Word: we
    [section] Counts 4 Original Word: section
    [rais] Counts 4 Original Word: raise
    [jesu] Counts 4 Original Word: jesus
    [into] Counts 4 Original Word: into
    [gather] Counts 4 Original Word: gathered
    [christ] Counts 4 Original Word: christ
    [chapter] Counts 4 Original Word: chapter
    [all] Counts 4 Original Word: all
    [which] Counts 3 Original Word: which
    [unto] Counts 3 Original Word: unto
    [those] Counts 3 Original Word: those
    [speak] Counts 3 Original Word: speak
    [scriptur] Counts 3 Original Word: scripture
    [repres] Counts 3 Original Word: represented
    [point] Counts 3 Original Word: points
    [on] Counts 3 Original Word: on
    [me] Counts 3 Original Word: me
    [lord] Counts 3 Original Word: lord
    [he] Counts 3 Original Word: he
    [figur] Counts 3 Original Word: figurative
    [collect] Counts 3 Original Word: collected
    [your] Counts 2 Original Word: your
    [view] Counts 2 Original Word: view
    [three] Counts 2 Original Word: three
    [take] Counts 2 Original Word: take
    [tabernacl] Counts 2 Original Word: tabernacle
    [system] Counts 2 Original Word: system
    [represent] Counts 2 Original Word: representation
    [progress] Counts 2 Original Word: progress
    [present] Counts 2 Original Word: presented
    [not] Counts 2 Original Word: not
    [mean] Counts 2 Original Word: mean
    [margin] Counts 2 Original Word: margin
    [line] Counts 2 Original Word: line
    [like] Counts 2 Original Word: like
    [it] Counts 2 Original Word: it
    [hi] Counts 2 Original Word: his
    [hebrew] Counts 2 Original Word: hebrews
    [have] Counts 2 Original Word: have
    [ha] Counts 2 Original Word: has
    [god] Counts 2 Original Word: god
    [from] Counts 2 Original Word: from
    [first] Counts 2 Original Word: first
    [everyth] Counts 2 Original Word: everything
    [do] Counts 2 Original Word: do
    [coven] Counts 2 Original Word: covenant
    [come] Counts 2 Original Word: come
    [by] Counts 2 Original Word: by
    [but] Counts 2 Original Word: but
    [broader] Counts 2 Original Word: broader
    [at] Counts 2 Original Word: at
    [would] Counts 1 Original Word: would
    [will] Counts 1 Original Word: will
    [who] Counts 1 Original Word: who
    [when] Counts 1 Original Word: when
    [were] Counts 1 Original Word: were
    [well] Counts 1 Original Word: well
    [walk] Counts 1 Original Word: walk
    [vers] Counts 1 Original Word: verse
    [veri] Counts 1 Original Word: very
    [under] Counts 1 Original Word: under
    [through] Counts 1 Original Word: through
    [thi] Counts 1 Original Word: this
    [these] Counts 1 Original Word: these
    [thei] Counts 1 Original Word: they
    [than] Counts 1 Original Word: than
    [testament] Counts 1 Original Word: testament
    [stretch] Counts 1 Original Word: stretch
    [stephen] Counts 1 Original Word: stephen
    [stand] Counts 1 Original Word: stands
    [spoke] Counts 1 Original Word: spoke
    [spiritu] Counts 1 Original Word: spiritual
    [spirit] Counts 1 Original Word: spirit
    [somewhat] Counts 1 Original Word: somewhat
    [so] Counts 1 Original Word: so
    [simpli] Counts 1 Original Word: simply
    [shall] Counts 1 Original Word: shall
    [seven] Counts 1 Original Word: seven
    [saw] Counts 1 Original Word: saw
    [said] Counts 1 Original Word: said
    [sai] Counts 1 Original Word: says
    [s] Counts 1 Original Word: s
    [resurrect] Counts 1 Original Word: resurrection
    [psalm] Counts 1 Original Word: psalms
    [prophesi] Counts 1 Original Word: prophesying
    [propheci] Counts 1 Original Word: prophecy
    [principl] Counts 1 Original Word: principles
    [predecessor] Counts 1 Original Word: predecessors
    [person] Counts 1 Original Word: persons
    [patriarch] Counts 1 Original Word: patriarchs
    [old] Counts 1 Original Word: old
    [now] Counts 1 Original Word: now
    [noah] Counts 1 Original Word: noah
    [new] Counts 1 Original Word: new
    [mighti] Counts 1 Original Word: mighty
    [might] Counts 1 Original Word: might
    [marvel] Counts 1 Original Word: marvellous
    [make] Counts 1 Original Word: makes
    [look] Counts 1 Original Word: look
    [letter] Counts 1 Original Word: letter
    [know] Counts 1 Original Word: know
    [just] Counts 1 Original Word: just
    [israel] Counts 1 Original Word: israel
    [if] Counts 1 Original Word: if
    [how] Counts 1 Original Word: how
    [himself] Counts 1 Original Word: himself
    [here] Counts 1 Original Word: here
    [had] Counts 1 Original Word: had
    [ground] Counts 1 Original Word: ground
    [glanc] Counts 1 Original Word: glance
    [get] Counts 1 Original Word: get
    [for] Counts 1 Original Word: for
    [find] Counts 1 Original Word: find
    [figurehead] Counts 1 Original Word: figurehead
    [fact] Counts 1 Original Word: fact
    [express] Counts 1 Original Word: expression
    [exodu] Counts 1 Original Word: exodus
    [everi] Counts 1 Original Word: every
    [enoch] Counts 1 Original Word: enoch
    [doe] Counts 1 Original Word: does
    [divid] Counts 1 Original Word: divided
    [dispens] Counts 1 Original Word: dispensations
    [discours] Counts 1 Original Word: discourse
    [did] Counts 1 Original Word: did
    [detail] Counts 1 Original Word: detail
    [deal] Counts 1 Original Word: deal
    [cours] Counts 1 Original Word: course
    [corpor] Counts 1 Original Word: corporate
    [content] Counts 1 Original Word: content
    [climax] Counts 1 Original Word: climax
    [clear] Counts 1 Original Word: clear
    [children] Counts 1 Original Word: children
    [charact] Counts 1 Original Word: character
    [call] Counts 1 Original Word: called
    [brethren] Counts 1 Original Word: brethren
    [blood] Counts 1 Original Word: blood
    [been] Counts 1 Original Word: been
    [be] Counts 1 Original Word: be
    [argument] Counts 1 Original Word: argument
    [ani] Counts 1 Original Word: any
    [along] Counts 1 Original Word: along
    [ag] Counts 1 Original Word: ages
    [act] Counts 1 Original Word: acts
    [account] Counts 1 Original Word: account
    [abraham] Counts 1 Original Word: abraham
    [abel] Counts 1 Original Word: abel
    
Time cost 14 seconds. To long seems.
