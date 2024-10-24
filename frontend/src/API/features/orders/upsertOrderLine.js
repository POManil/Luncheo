export const upsertOrderLine = async (client, orderLine) => {
  try {
    const res = await client.post("/order-line", orderLine);
    return res;
  } catch (error) {
    console.error(error);
    throw error;
  }
}