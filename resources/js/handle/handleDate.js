export function convertToDate(string) {
    var date = new Date(string);
    if (isNaN(date.getFullYear())) return undefined;
    var res = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate()
    return res
}