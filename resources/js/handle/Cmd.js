export function convertStringCurrency(strnum) {
    //12345678 to 123.345.678
    var res = formatcurrency(parseInt(strnum));
    return res;
}

export function formatcurrency(n) {
    return n.toFixed(0).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
    });
}
export function removeDot(str) {
    return str.replace(".", "")
}

export function convertnametovalue(str) {

    var res = [];
    str.forEach(element => {
        res.push({
            id: element.id,
            value: element.name.toString(),

        });
    });
    // console.log(res);
    return res;
}