import axios from 'axios';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const API_KEY = import.meta.env.VITE_API_KEY;

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {  
    'X-API-KEY': API_KEY 
  },
  withCredentials: true 
});

export const searchCocktailsByName = async (query) => {
  try {
    const response = await apiClient.get('/search/name', {
      params: { q: query } 
    });
    return response.data;
  } catch (error) {
    console.error("Fehler bei der Namenssuche:", error);
    throw error;
  }
};

export const searchCocktailsByIngredient = async (query) => {
  try {
    const response = await apiClient.get('/search/ingredient', {
      params: { q: query }
    });
    return response.data;
  } catch (error) {
    console.error("Fehler bei der Zutatensuche:", error);
    throw error;
  }
};

export const getCocktailDetailsById = async (id) => {
    try {
      const response = await apiClient.get(`/lookup/${id}`);
      return response.data[0]; 
    } catch (error) {
      console.error("Fehler beim Holen der Details:", error);
      throw error;
    }
};

export const getRandomCocktail = async () => {
    try {
      const response = await apiClient.get('/random');
      return response.data[0];
    } catch (error) {
      console.error("Fehler beim Holen eines zufälligen Cocktails:", error);
      throw error;
    }
};