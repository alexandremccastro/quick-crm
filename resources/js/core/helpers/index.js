export const parseJSON = (jsonString) => {
  return JSON.parse(jsonString)
}

export const isDefined = (item) => {
  return item !== undefined && item !== null
}
