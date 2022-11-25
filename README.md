# Sobre la app cli
Procesa archivos segun especificacion compartida, test cobrodigital.com
Contiene implementacion del Patron de Diseno Strategy. 

## Sobre la especificidad de las acciones comunes y el patron strategy. 
Si bien se pudo haber declarado en la interfaz las acciones comunes compartidas tales como (get_header, get_footer, etc) se ha omitido esto en favor de mantener un principio abierto respecto a interpretacion de archivos con diferente formato, por ejemplo (json o xml) y en su lugar se ha dejado una accion comun de procesar archivo delegando a cada estrategia los detalles de la implementacion. 

## Prerequisitos
1. El archivo *interpreter* debe ser ejecutable.
2. Debes tener instalada una version de PHP igual o superior a 7.4.
3. Debes poseer los tres archivos en formato .txt.
4. Debes tener instalado composer, y ejecutar *composer dump-autoload* para que las clases sean cargadas correctamente.

### Como utilizar el interprete
Para ejecutar el interprete debes ejecutar el comando desde la terminal:

```./interpreter a b c```

Considerando:
- a, b y c son strings y corresponden a un path valido hacia los archivos a ser interpretados.

### Ejemplo de ejecucion 
```./interpreter '/my-file-1.txt' '/my-file-2.txt' '/my-file-3.txt'  ```



