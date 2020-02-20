/*
 * Simple async wait function
 */
export default (delay, ...args) =>
  new Promise((resolve) => setTimeout(resolve, delay, ...args))
