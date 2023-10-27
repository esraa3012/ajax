// console.log('toto');
// let str = 'blblb';
// let nbr = 14;
//  let arr = ["coco","toto"];

//  console.log(arr[0][0], arr[1][0]);
//  console.log(str[0]);

const form = document.querySelector('form');
const input = document.querySelector('input');

form.addEventListener('submit', (e) =>{
    e.preventDefault();
    //console.log(input.value);
    const formValue = new FormData(form);
    fetch("insert.php", {
            method: "POST",
            body: formValue
        })
        .then(res => res.json())
        .then(data => {
            console.log(data)
        })

})