#Dependency Injection

Di dalam pengembangan perangkat lunak, ada konsep yang namanya Dependency Injection
Dependency Injection adalah teknik dimana sebuah object menerima object lain yang dibutuhka atau istilahnya dependencies
Saat kita membuat object, sering sekali kita membuat object yang butuh object lain
https://en.wikipedia.org/wiki/Dependency_injection

Dari class Foo dan Bar kita tahu bahwa Bar membutuhkan Foo, artinya Bar depends-on Foo, atau Foo adalah dependency untuk BarDependency Injection berarti kita perlu memasukkan object Foo ke dalam Bar, sehingga Bar bisa menggunakan object Foo Pada kode Foo dan Bar kita menggunakan Constructor untuk melakukan injection (memasukkan dependency), sebenarnya caranya tidak hanya menggunakan Constructor, bisa menggunakan Attribute atau Function, namun sangat direkomendasikan menggunakan Constructor agar bisa terlihat jelas dependencies nya dan kita tidak lupa menambahkan dependencies nya
