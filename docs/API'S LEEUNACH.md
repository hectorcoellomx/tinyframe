
## GUARDAR USUARIO(GUARDAR Y ACTUALIZAR)
~~~
Route::post('/v1/users', [UserController::class, 'store']);
~~~
==url:==
~~~
http://127.0.0.1:8000/api/v1/users/?
~~~
![[Pasted image 20240928161813.png]]

## LISTADO DE LIBROS (CALFICACIÓN, COLECCIÓN, ESTANTERIAS, MÁS LEÍDOS Y POR PALABRA BUSCADA)
~~~
Route::get('/v1/books',[bookController::class, 'book']);
~~~
==url:==
~~~
http://127.0.0.1:8000/api/v1/books/?filter=category&value=5
~~~
**Filtrar por category, collection, shelving, most_read, search**
**Value = categoria_id, 
collection_id,
user_id, 
Only the filter tha extracts the most read
keywords or title **
![[Pasted image 20241001225221.png]]

## LISTADO DE CATEGORIAS
~~~
Route::get('/v1/categories/',[CategoryController::class, 'category']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/categories
~~~
![[Pasted image 20241001225156.png]]

## LISTADO DE COLECCIONES
~~~
Route::get('/v1/collections/',[CollectionController::class, 'collection']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/collections
~~~
![[Pasted image 20241001225419.png]]

## GUARDAR AVANCES(AGREGAR. ACTUALIZAR)
~~~
Route::post('/v1/progress/',[ProgressController::class, 'store']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/progress/
~~~
![[Pasted image 20241001225542.png]]

~~~
Route::patch('/v1/progress/{id}',[ProgressController::class, 'update']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/progress/1
~~~
![[Pasted image 20241001225643.png]]

## AGREGAR ESTANTERIA
~~~
Route::post('/v1/shelves/',[ShelvesController::class, 'store']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/shelves
~~~

~~~
{
"book_id": "B005",
"user_id": 16
}
~~~
![[Pasted image 20241001225946.png]]

## AGREGAR CALIFICACIÓN INDIVIDUAL
~~~
Route::post('/v1/ratings/{id}',[RatingController::class, 'store']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/ratings/B004
~~~
![[Pasted image 20241001230232.png]]

## OBTENER CALFICACIÓN INDIVIDUAL
~~~
Route::get('/v1/ratings/{id}',[RatingController::class, 'show']);
~~~

==url:==
~~~
http://127.0.0.1:8000/api/v1/ratings/B004
~~~
![[Pasted image 20241001230428.png]]


## OBTENER LIBRO INDIVIDUAL (CALFICACIÓN, AVANCE)
~~~
Route::get('/v1/books/{id}/{user_id}',[bookController::class, 'show']);
~~~
==url:==
~~~
http://127.0.0.1:8000/api/v1/books/B004/19
~~~
![[Pasted image 20241001230721.png]]
