import Head from 'next/head'
import Header from '../../components/Header'
import { Flex, Box, Text, Input, Button } from '@chakra-ui/core'
import styled from '@emotion/styled'
import FlexBox from '../../components/shared/FlexBox'
import Footer from '../../components/Footer'
import PreloadFetch from '../../components/Utils/PreloadFetch'

const OverviewTable = styled.table`
	width: 100%;

	table {
		width: 100%
	}

	tr th {
			text-align: left;
	}

	#right-align{
		text-align: right;
	}
`
const TotalTable = styled.table`
  margin-left: auto;

	tr th {
			text-align: right;
	}
`

const OrderConfirmStep3 = () => {

	return (
		<>
			<Head>
				<title>Homepage</title>
				<PreloadFetch apiPath='/products?limit=50' />
				<PreloadFetch apiPath='/products?sales=true&limit=6' />
			</Head>

			<Flex direction='column'
				  minHeight='100vh'
				  justifyContent='space-between'>
				<Header />

        <FlexBox>

          <Flex align='center' wrap='wrap' justifyContent="center">
            <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 0 1041.65 44.41">
            <g id="Steps" transform="translate(-433.35 -237.59)">
              <path id="Path_3" data-name="Path 3" d="M0,0H382.65V44.41H0Z" transform="translate(1079.351 237.59)" fill="#2c3e50"/>
              <path id="Path_4" data-name="Path 4" d="M0,0H321.73l38.85,23.895L321.73,44.41H0Z" transform="translate(775.351 237.59)" fill="#f1c42c"/>
              <path id="Path_1" data-name="Path 1" d="M0,0H350.2l42.287,23.895L350.2,44.41H0Z" transform="translate(433.35 237.59)" fill="#1dbc9c"/>
              <text id="Stap_1:_Informatie" data-name="Stap 1: Informatie" transform="translate(544 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 1: Informatie</tspan></text>
              <text id="Stap_2:_Betaling" data-name="Stap 2: Betaling" transform="translate(872 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 2: Betaling</tspan></text>
              <text id="Stap_3:_Confirmatie" data-name="Stap 3: Confirmatie" transform="translate(1204 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 3: Confirmatie</tspan></text>
            </g>
            </svg>
          </Flex>

          <Text mt="20px" mb="10px" px="15px" fontSize="lg" fontWeight="bold">Stap 3: Overzicht</Text>

          <Flex w="100%" wrap='wrap'>

            <Flex w="50%" wrap="wrap">
              <Text mt="10px" mb="10px" px="15px" fontSize="1.2rem" fontWeight="bold" w="100%" >Gegevens</Text>
              <Box w="50%" px="15px" mb="10px">
                <Text mb="2px" w="100%" fontWeight="bold">Naam</Text>
                <Text mb="2px" w="100%">Voornaam + Achternaam</Text>
                <Text mb="2px" w="100%" fontWeight="bold">Adres</Text>
                <Text mb="2px" w="100%">Straat + Huisnummer</Text>
                <Text mb="2px" w="100%">Postcode + Stad</Text>
              </Box>
              <Box w="50%" px="15px" mb="10px">
                <Text mb="2px" fontWeight="bold">E-mail</Text>
                <Text mb="2px">jasperstolwijk@icloud.com</Text>
                <Text mb="2px" fontWeight="bold">Telefoonnummer</Text>
                <Text mb="2px">+3162833143</Text>
              </Box>
            </Flex>

            <Flex w="50%" wrap="wrap">
              <Text mt="10px" mb="10px" fontSize="1.2rem" fontWeight="bold" w="100%" >Betaalmethode</Text>
              <Flex w="75%" bg="white" py="20px" px="10px" wrap="wrap" >
                <Flex w="15%" justifyContent="center" my="auto">
                  <input type="radio" hidden />
                </Flex>
                <Flex w="35%" justifyContent="center" my="auto" >
                  <svg xmlns="http://www.w3.org/2000/svg" width="62.857" height="55" viewBox="0 0 62.857 55">
                    <path id="wallet-solid" d="M56.621,43.786H9.821a1.964,1.964,0,0,1,0-3.929H56.964a1.964,1.964,0,0,0,1.964-1.964A5.893,5.893,0,0,0,53.036,32H7.857A7.857,7.857,0,0,0,0,39.857V79.143A7.857,7.857,0,0,0,7.857,87H56.621a6.078,6.078,0,0,0,6.237-5.893V49.679A6.078,6.078,0,0,0,56.621,43.786ZM51.071,69.321A3.929,3.929,0,1,1,55,65.393,3.929,3.929,0,0,1,51.071,69.321Z" transform="translate(0 -32)" fill="#707070" />
                  </svg>
                </Flex>
                <Box w="50%" bg="white" py="20px" px="10px">
                  <Text>Contant</Text>
                  <Text>Kosten: € 0,00</Text>
                </Box>
              </Flex>
            </Flex>

            <Flex w="100%" wrap="wrap"  px="15px">
              <Text mt="10px" mb="10px" fontSize="1.2rem" fontWeight="bold" w="100%" >Producten</Text>
              <Box w="100%">
                <OverviewTable>
                  <tr>
                    <th># ID</th>
                    <th>Naam</th>
                    <th id="right-align">Prijs</th>
                  </tr>
                  {/* {data.map((currentProduct: ConsumerProduct) => ( */}
                  <tr>
                    <td># 123</td>
                    <td>Een Coole VR bril</td>
                    <td id="right-align">€ 500,00</td>
                  </tr>
                  {/* ))} */}
                </OverviewTable>
              </Box>
              <Box w="100%" mt="10px" mb="20px">
                <TotalTable>
                  <tr>
                    <th>BTW</th>
                    <td>€ {500 * 0.21}</td>
                  </tr>
                  <tr>
                    <th>Totaal</th>
                    <td>€ 500,00</td>
                  </tr>
                </TotalTable>
                <Flex>
                  <Text fontSize="sm" ml="auto">Inclusief btw en thuiskopieheffing</Text>
                </Flex>
              </Box>

            </Flex>
          </Flex>

					<Flex alignItems='end' w='100%'>
						<Button ml='auto' bg='secondary.500' color='white' type='submit' rightIcon="arrow-forward" >Bestelling betalen</Button>
					</Flex>
          </FlexBox>
				<Footer />
			</Flex>
		</>
	)
};

export default OrderConfirmStep3
