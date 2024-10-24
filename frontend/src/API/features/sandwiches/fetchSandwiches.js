/**
 * Fetch a list of all sandwiches.
 * @param {object} client  
 * @returns {Array<object>}
 */
export const fetchSandwiches = async (client) => {
  try {
    const sandwiches = await client.get('/sandwich/all');
    return sandwiches;
  } catch (error) {
    console.error(error);
    throw error;
  }
}