import React from 'react';
import { Typography, TextField, Button, Box } from '@mui/material';

function SearchPage() {
  return (
    <Box sx={{ textAlign: 'center', my: 4 }}>
      <Typography variant="h2" component="h1" gutterBottom>
        Cocktail Explorer
      </Typography>
      <Typography variant="body1" color="text.secondary" sx={{ mb: 4 }}>
        Search for your favorite cocktails and discover new recipes!
      </Typography>

      <Box
        component="form"
        sx={{
          display: 'flex',
          justifyContent: 'center',
          gap: 1.5, 
          width: { xs: '100%', md: '70%' }, 
          margin: '0 auto'
        }}
      >
        <TextField
          fullWidth
          id="search-bar"
          label="search for cocktails..."
          variant="outlined"
        />
        <Button variant="contained" size="large" type="submit">
          Search
        </Button>
      </Box>

    </Box>
  );
}

export default SearchPage;