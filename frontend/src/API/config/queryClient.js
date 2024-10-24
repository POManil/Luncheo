import { QueryClient } from '@tanstack/react-query';

/**
 * Creates a linear retry function.
 * @param {number} milliseconds - The number of milliseconds to multiply by the attempt count.
 * @returns {(attempt:number) => number} A function that calculates the delay based on the attempt count.
 */
const linearRetry = (milliseconds) => (attempt) => attempt * milliseconds;

export const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      retry: 3,
      retryDelay: linearRetry(500)
    }
  }
});