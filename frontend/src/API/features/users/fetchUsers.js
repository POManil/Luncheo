/**
 * Fetch a list of users based on a param. Defaults to `all`.
 * @param {object} client 
 * @param {number | 'all'} [param] 
 * @returns {Array<object>}
 */
export const fetchUsers = async (client, param) => {
  try {
    const users = await client.get('/user/' + param);
    return users;
  } catch (error) {
    console.error(error);
    throw error;
  }
}