/**
 * Fetch a list of orders based on a param. Defaults to `all`.
 * @param {object} client 
 * @param {number | 'all'} [param] 
 * @returns {Array<object>}
 */
export const fetchOrders = async (client, param) => {
  try {
    const res= await client.get('order/' + param);
    console.log("res", res);
    return res
  } catch (error) {
    console.error(error);
    throw error;
  }
}