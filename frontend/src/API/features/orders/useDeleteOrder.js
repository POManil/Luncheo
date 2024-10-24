import { useAxios } from '../../config/AxiosContext';
import { useMutation, useQueryClient } from '@tanstack/react-query';

/**
 * Fetch a list of orders based on a param. Defaults to `all`.
 * @param {object} client 
 * @param {number} orderId 
 */
const deleteOrder = async (client, orderId) => {
  try {
    return await client.delete('order/' + orderId);
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useDeleteOrder = () => {
  const client = useAxios();
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({orderId}) => deleteOrder(client, orderId),
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ['orders'] });
    },
  });
};