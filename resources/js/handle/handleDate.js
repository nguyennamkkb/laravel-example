export function convertToDate (string) {
  const date = new Date(string)
  if (isNaN(date.getFullYear())) return undefined
  const res =
    date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()
  return res
}
