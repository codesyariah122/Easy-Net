		
data(){
			return {
				features: []
			}
		},

SlideFeature(){
				const img_url =  '~/assets/images/features'
				this.features = [
					{
						type: 'game',
						images: [
							{
								id:1,
								url: require(`~/assets/images/features/game/game1.jpg`)
							},
							{
								id:2,
								url: require(`~/assets/images/features/game/game2.jpg`)
							},
							{
								id:3,
								url: require(`~/assets/images/features/game/game3.jpg`)
							},
							{
								id:4,
								url: require(`~/assets/images/features/game/game4.jpg`)
							},
							{
								id:5,
								url: require(`~/assets/images/features/game/game5.jpg`)
							},
							{
								id:6,
								url: require(`~/assets/images/features/game/game6.jpg`)
							},
							{
								id:7,
								url: require(`~/assets/images/features/game/game7.jpg`)
							},
							{
								id:8,
								url: require(`~/assets/images/features/game/game8.jpg`)
							},
							{
								id:9,
								url: require(`~/assets/images/features/game/game9.jpg`)
							},
							{
								id:10,
								url: require(`~/assets/images/features/game/game10.jpg`)
							}
						]
					}
				]
			}