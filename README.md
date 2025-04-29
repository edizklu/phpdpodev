# 🏭 Üretim Hattı İş Zamanlama Optimizasyonu (Dinamik Programlama - PHP) ✨

Bu proje, belirli bir sıraya sahip $n$ adet işin, $m$ farklı makine üzerinde, makineler arası geçiş maliyetleri dikkate alınarak **minimum toplam sürede** tamamlanmasını amaçlayan güçlü bir Dinamik Programlama (Dynamic Programming - DP) çözümünü PHP dilinde sunar. Üretim süreçlerinizi optimize ederek verimliliği artırın! 🚀

## 🎯 Problem Tanımı

Bir üretim hattında, $J_1, J_2, \dots, J_n$ şeklinde **kesinlikle sırasıyla** tamamlanması gereken $n$ adet iş bulunmaktadır. Bu kritik işler, $M_1, M_2, \dots, M_m$ olmak üzere $m$ farklı yeteneklere sahip makinede yapılabilir.

* Her iş $i$'nin, her makine $j$ üzerindeki tamamlanma süresi $P_{i,j}$ olarak titizlikle belirlenmiştir. ⏱️

* Makineler arasında bir geçiş yapılması durumunda kaçınılmaz bir geçiş maliyeti (ayar süresi, taşıma maliyeti vb.) ortaya çıkar. Makine $k$'dan makine $j$'ye geçişin maliyeti $C_{k,j}$ olarak tanımlanmıştır. ($C_{k,k}$ genellikle 0'dır, yani aynı makinede kalmanın ek maliyeti yoktur). 🔄

Temel amacımız, tüm işleri belirlenen sıra ile tamamlamak için hangi işin hangi makinede yapılacağına akıllıca karar vererek (yani en uygun makine atama dizisi $(M_{j_1}, M_{j_2}, \dots, M_{j_n})$ belirleyerek) toplam süreyi **minimuma** indirmektir. Toplam süre, işlerin tamamlanma sürelerinin ve ardışık işler arasındaki makineler arası geçiş maliyetlerinin toplamıdır.

Matematiksel olarak hedefimiz, $\sum_{i=1}^{n} P_{i, j_i} + \sum_{i=1}^{n-1} C_{j_i, j_{i+1}}$ ifadesini minimize eden $(j_1, j_2, \dots, j_n)$ indis dizisini bulmaktır. Bu, en verimli üretim rotasını keşfetmek anlamına gelir! ✨

## 🧠 Kullanılan Algoritma: Dinamik Programlama (Tablolama)

Bu karmaşık problem, optimal alt yapıya ve çakışan alt problemlere sahip olduğu için Dinamik Programlamanın gücüyle çözülür. Kullanılan yöntem, alt problemleri sistematik olarak çözen ve sonuçları bir tabloda saklayan Tablolama (Bottom-Up) yaklaşımıdır.

Algoritmanın temel prensibi şudur:

* `dp[i][j]`: İlk `i+1` işin başarıyla tamamlanması ve `i+1`-inci işin `j+1`-inci makinede yapılması durumunda elde edilen **minimum** toplam süreyi temsil eden bir tablo (`dp[n][m]`) tanımlanır. (0-indeksleme kullanılmıştır). Bu tablo, çözümümüzün hafızasıdır. 💾

* Tablonun ilk satırı (`dp[0][j]`), ilk işin her makinedeki direkt işlem süresiyle doldurulur. Bu başlangıç noktasıdır, henüz bir geçiş maliyeti yoktur.

* Tablo, işler üzerinden (i=1'den n-1'e kadar) ve her iş için makineler üzerinden (j=0'dan m-1'e kadar) adım adım doldurulur. Her hücre, ilgili alt problemin en iyi çözümünü içerir.

* `dp[i][j]` değeri hesaplanırken, bir önceki işin (`i-1`) yapılabileceği tüm olası makineler (`k`) akıllıca denenir. `dp[i][j]` değeri, `dp[i-1][k]` (önceki işi makine k'da bitirmenin min süresi) + `transition_cost[k][j]` (makine k'dan j'ye geçiş maliyeti) + `processing_time[i][j]` (mevcut işi makine j'de yapma süresi) ifadesinin tüm olası `k` değerleri üzerindeki **minimumu** olarak bulunur. Bu, her adımda en iyi kararı vermemizi sağlar. 🤔

* Tablo tamamen doldurulduktan sonra, son işin (`n-1`) herhangi bir makinede tamamlanmasının minimum süresi (`dp[n-1]` satırındaki en küçük değer) bize nihai, **global minimum toplam süreyi** verir. İşte aradığımız cevap! ✅

## 💻 Kurulum ve Çalıştırma

Bu projeyi çalıştırmak oldukça basittir!

1. Bilgisayarınızda PHP yüklü olduğundan emin olun. Eğer yüklü değilse, [PHP resmi web sitesinden](https://www.php.net/downloads.php) indirebilirsiniz.

2. Proje dosyalarını (PHP kodunu içeren dosya) yerel bilgisayarınızda uygun bir dizine yerleştirin.

3. Terminal veya komut istemcisini açın ve proje dosyalarınızın bulunduğu dizine gidin.

4. PHP dosyasını çalıştırmak ve sonuçları görmek için aşağıdaki komutu kullanın:

   ```bash
   php dpodev.php

   ## 📥 Girdi Formatı

Problem girdileri, esneklik sağlamak amacıyla PHP kodunun içerisinde değişkenler olarak tanımlanmıştır:

* `$n`: İş sayısı (integer). 🔢
* `$m`: Makine sayısı (integer). 🏭
* `$processingTime`: İşlem sürelerini temsil eden `n x m` boyutunda bir dizi (array). `$processingTime[i][j]`, `i+1`. işin `j+1`. makinedeki süresini verir (0-indeksli). Bu matris, her işin her makinedeki performansını gösterir.
* `$transitionCost`: Geçiş maliyetlerini temsil eden `m x m` boyutunda bir dizi (array). `$transitionCost[k][j]`, `k+1`. makineden `j+1`. makineye geçiş maliyetini verir (0-indeksli). Bu matris, makine değiştirmenin getirdiği ek yükü yansıtır.

Örnek girdiler kodun içerisinde mevcuttur ve kendi senaryolarınıza uyacak şekilde kolayca güncellenebilir.

## 📊 Çıktı Formatı

Kod başarıyla çalıştırıldığında, terminale şu anlaşılır bilgiler yazdırılır:

* İşlem Süreleri Matrisi: Girdi olarak verilen işlem sürelerini teyit eder.
* Geçiş Maliyetleri Matris: Girdi olarak verilen geçiş maliyetlerini teyit eder.
* Hesaplanan DP Tablosu: Algoritmanın adım adım hesapladığı `dp[i][j]` değerlerini gösterir. Bu tablo, çözüm sürecini anlamak için çok faydalıdır.
* Minimum Toplam Süre: Tüm işlerin tamamlanması için gereken nihai, en kısa süreyi belirtir. İşte optimizasyonun sonucu! 🎉

DP Tablosu, algoritmanın adım adım hesapladığı minimum süreleri gösterir ve çözümün nasıl inşa edildiğini anlamanıza yardımcı olur.

## ⏱️ Uzay ve Zaman Karmaşıklığı Analizi

Algoritmanın performansı şu şekildedir:

* **Zaman Karmaşıklığı:** <span class="math-inline">O\(nm^2\)</span>. Algoritma, <span class="math-inline">n</span> iş ve <span class="math-inline">m</span> makine için üç iç içe döngü kullanır. Dış döngü iş sayısı <span class="math-inline">n</span>'e, içteki iki döngü ise makine sayısı <span class="math-inline">m</span>'ye bağlıdır. Bu, üstel bir brute-force çözümüne göre çok daha verimlidir.
* **Uzay Karmaşıklığı:** <span class="math-inline">O\(nm \+ m^2\)</span>. Bu, DP tablosunu (<span class="math-inline">O\(nm\)</span>) ve girdi matrislerini (<span class="math-inline">O\(nm\)</span> ve <span class="math-inline">O\(m^2\)</span>) saklamak için gereken alandır. DP tablosunun boyutu <span class="math-inline">O\(nm\)</span> genellikle dominant faktördür.

## 🤝 Katkıda Bulunma

Bu projeye katkıda bulunmaktan çekinmeyin! Fikirleriniz, hata düzeltmeleriniz veya yeni özellikleriniz varsa:

* Projeyi Fork edin.
* Kendi branch'inizi oluşturun (```git checkout -b feature/AmazingFeature```).
* Değişikliklerinizi Commit edin (```git commit -m 'Add some AmazingFeature'```).
* Branch'inizi Push edin (```git push origin feature/AmazingFeature```).
* Bir Pull Request açın.

Geri bildirimleriniz ve katkılarınız projenin gelişimine büyük değer katacaktır! 🙏
