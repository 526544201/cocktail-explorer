import React, { useState } from 'react';
import { 
  Typography, 
  TextField, 
  Button, 
  Box, 
  Grid,
  CircularProgress,
  Alert
} from '@mui/material';

import { searchCocktailsByName } from '../services/apiService';
import CocktailCard from '../components/CocktailCard';

function SearchPage() {
  const [searchTerm, setSearchTerm] = useState('');
  const [results, setResults] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (!searchTerm) return;

    setIsLoading(true);
    setError(null);
    setResults(null);

    try {
      const data = await searchCocktailsByName(searchTerm);
      
      if (data) {
        setResults(data);
      } else {
        setResults([]);
      }

    } catch (err) {
      setError('Fehler beim Abrufen der Cocktails. Versuche es später erneut.');
    } finally {
      setIsLoading(false);
    }
  };

  const renderResults = () => {
    if (isLoading) {
      return (
        <Box sx={{ display: 'flex', justifyContent: 'center', my: 4 }}>
          <CircularProgress />
        </Box>
      );
    }

    if (error) {
      return <Alert severity="error" sx={{ my: 4 }}>{error}</Alert>;
    }
    
    if (results === null) {
      return null; 
    }
    
    if (results.length === 0) {
      return <Alert severity="info" sx={{ my: 4 }}>No cocktails found.</Alert>;
    }

    return (
      <Grid container spacing={3} sx={{ my: 4 }}>
        {results.map((drink) => (
          <Grid item xs={12} sm={6} md={4} key={drink.idDrink}>
            <CocktailCard drink={drink} />
          </Grid>
        ))}
      </Grid>
    );
  };

  return (
    <Box sx={{ my: 4 }}>
      <Typography variant="h2" component="h1" gutterBottom>
        Cocktail Explorer
      </Typography>
      <Typography variant="body1" color="text.secondary" sx={{ mb: 4 }}>
        Search for your favorite cocktails and discover new recipes!
      </Typography>

      <Box
        component="form"
        onSubmit={handleSubmit}
        sx={{
          display: 'flex',
          gap: 1.5,
          width: { xs: '100%', md: '70%' },
          margin: '0 auto'
        }}
      >
        <TextField
          fullWidth
          label="Suche nach einem Cocktail (z.B. Margarita)"
          variant="outlined"
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
        />
        <Button 
          variant="contained" 
          size="large" 
          type="submit"
          disabled={isLoading}
        >
          {isLoading ? '...' : 'Suchen'}
        </Button>
      </Box>

      {renderResults()}

    </Box>
  );
}

export default SearchPage;