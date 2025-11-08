import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { Typography, CircularProgress, Alert } from '@mui/material';

import { getCocktailDetailsById } from '../services/apiService';

function DetailPage() {
  const { id } = useParams(); 
  const [drink, setDrink] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchDetails = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const data = await getCocktailDetailsById(id);
        setDrink(data);
      } catch (err) {
        setError('Fehler beim Laden der Cocktail-Details.');
      } finally {
        setIsLoading(false);
      }
    };

    fetchDetails();
  }, [id]);

  if (isLoading) {
    return <CircularProgress />;
  }

  if (error) {
    return <Alert severity="error">{error}</Alert>;
  }

  if (!drink) {
    return <Alert severity="info">Cocktail not found.</Alert>;
  }

  return (
    <div>
      <Typography variant="h2" component="h1">{drink.strDrink}</Typography>
      <Typography variant="body1" sx={{ mt: 2 }}>
        {drink.strInstructions}
      </Typography>
    </div>
  );
}

export default DetailPage;