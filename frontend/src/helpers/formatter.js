import { dateRegex } from "./regex";

/**
 * Returns a string with format `DD/MM/YYYY` or `YYYY/MM/DD` if param `reversed` is set to `true`.
 * @param {Date} toFormat 
 * @param {boolean} reversed If string should be `YYYY/MM/DD` instead of `DD/MM/YYYY`. Default to `false`.
 * @returns A formated string representing a date.
 */
export const toDateString = (toFormat, reversed = false) => {
  if(toFormat === "" || toFormat == null) {
    return "";
  }

  if(dateRegex.test(toFormat)) { 
    toFormat = toFormat.split("/").reverse().join('/'); 
  }
  
  toFormat = new Date(toFormat); 

  const formattedDate = {
    day: toFormat.getDate(),
    month: toFormat.getMonth() + 1,
    year: toFormat.getFullYear()
  }; 
  
  let output = `${formattedDate.day < 10 ? '0' : ''}${formattedDate.day}/${formattedDate.month < 10 ? '0' : ''}${formattedDate.month}/${formattedDate.year}`

  return reversed ? output.split('/').reverse().join('/') : output;
}