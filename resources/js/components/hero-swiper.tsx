import React from 'react';
import { Container, Typography, Button, Stack, Box } from '@mui/material';
import { createTheme, ThemeProvider } from '@mui/material/styles';

// Optional: Custom theme for demonstration, can be integrated into your main theme file
const theme = createTheme({
  palette: {
    primary: {
      main: '#556cd6',
    },
    secondary: {
      main: '#19857b',
    },
  },
});

export const HeroSwiper = () => {
  return (
    <ThemeProvider theme={theme}>
      {/* Box component acts as the container for the hero section, with padding and background color */}
      <Box
        sx={{
          bgcolor: 'background.paper',
          pt: 8, // padding top
          pb: 6, // padding bottom
        }}
      >
        {/* Container limits the width of the content */}
        <Container maxWidth="sm">
          {/* Typography for the main headline */}
          <Typography
            component="h1"
            variant="h2"
            align="center"
            color="text.primary"
            gutterBottom // adds a bottom margin
          >
            Album example
          </Typography>
          {/* Typography for the supporting description */}
          <Typography variant="h5" align="center" color="text.secondary" paragraph>
            Something short and leading about the collection below—its contents, the creator, etc. Make it
            short and sweet, but not too short so folks don&apos;t simply skip over it entirely.
          </Typography>
          {/* Stack for arranging buttons with spacing */}
          <Stack
            sx={{ pt: 4 }} // padding top
            direction="row"
            spacing={2} // spacing between buttons
            justifyContent="center" // centers the stack horizontally
          >
            <Button variant="contained" color="primary">Main call to action</Button>
            <Button variant="outlined" color="secondary">Secondary action</Button>
          </Stack>
        </Container>
      </Box>
    </ThemeProvider>
  );
};
