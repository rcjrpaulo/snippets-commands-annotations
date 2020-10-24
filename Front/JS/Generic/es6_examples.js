// NOVO FOR DO JS

//antigo
 for (let i = 0; i < bubbles.length; i++) {
	bubbles[i].move();
	bubbles[i].show();
}

//novo
 for (let bubble of bubbles) {
	bubble.move();
	bubble.show();
}

//quando precisa da chave
for (let [key, value] of iterable) {}

//ARROW FUNCTION
//normal
args.map(function(arg){ return arg.id})

//arrow function
args.map( arg => arg.id)

//FILTER
//ELE TRAZ SOMENTE OS VALORES SETADOS VERDADEIROS
let vals = [null, undefined, 'rs', false, 12, 15]

let kk = vals.filter(k => k )
// saida (3) ["rs", 12, 15]